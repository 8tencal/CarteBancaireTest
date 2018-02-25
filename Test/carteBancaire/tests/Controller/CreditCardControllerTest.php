<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use App\Entity\CreditCard;
use App\Form\CreditCardType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CreditCardControllerTest extends WebTestCase
{

    private $client = null;
    private $crawler = null;
    private $em;

    /* Une façon plus propre de réaliser les tests...
    Permet aussi de les rendres indépendants du test de login */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->logIn();
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('antoine', "test", $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }


    /**
     * @runInSeparateProcess
     */
    public function testAffichageMesCartes()
    {

        $this->crawler=$this->client->request('GET','/credit/mycards');
        // Test qu'on arrive bien à afficher la page ou il y a mes cartes.
        $this->assertContains('Mes cartes',$this->crawler->filter('div.panel-heading')->text());

    }

    /**
     * @runInSeparateProcess
     */
    public function testAjoutCarte()
    {


        $creditCard = $this->em->getRepository(CreditCard::class)->findByCardNumber('1234657438579284');
        if($creditCard != null)
        {
            // on a un array car on a pas fait un find by Id. Donc on doit récupérer les entités dedans.
            foreach ($creditCard as $card) {
                $this->em->remove($card);
            }
            $this->em->flush();
        }

        $this->crawler=$this->client->request('GET','/credit/addcard');

        $form = $this->crawler->selectButton('add carte')->form();

// set some values
        $form['credit_card[cardNumber]'] = '1234657438579284';
        $form['credit_card[expirationDate][year]'] = '2019';
        $form['credit_card[expirationDate][month]'] = 1;
        $form['credit_card[expirationDate][day]'] = '12';
        $form['credit_card[csv]'] = '123';
        $this->crawler = $this->client->submit($form);

        // test qu'on est bien redirigé.
        $this->assertTrue($this->client->getResponse()->isRedirect());
        //Suivons la redirection
        $this->crawler = $this->client->followRedirect();


        // Test qu'on arrive bien à afficher la page ou il y a mes cartes.
        $this->assertEquals(1,$this->crawler->filter('td:contains("1234657438579284")')->count());

    }


    /**
     * @runInSeparateProcess
     */
    public function testSuppressionCarteDoctrine()
    {

        // Test de la capacité de doctrine a supprimer une carte.
        $creditCard = $this->em->getRepository(CreditCard::class)->findByCardNumber('1234657438579284');
        if($creditCard != null)
        {
            // on a un array car on a pas fait un find by Id. Donc on doit récupérer les entités dedans.
            foreach ($creditCard as $card) {
                $this->em->remove($card);
            }
            $this->em->flush();
        }

        $this->crawler=$this->client->request('GET','/credit/mycards');



        $this->assertEquals(0,$this->crawler->filter('td:contains("1234657438579284")')->count());

    }

    /**
     * @runInSeparateProcess

    public function testSuppressionCarte()
    {

        // On rajoute une carte pour le test.
        $this->testAjoutCarte();
        $this->crawler=$this->client->request('GET','/credit/mycards');
        $button = $this->crawler->filter('tr:contains("1234657438579284")')->eq(0)->link();
        var_dump($button);
        $this->crawler = $this->client->click($button);


        $this->assertEquals(0,$this->crawler->filter('td:contains("1234657438579284")')->count());

    }*/


}