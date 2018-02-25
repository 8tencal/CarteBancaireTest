<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class AdminControllerpasencoretest extends WebTestCase
{


    private $client = null;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->logIn();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSecuredHello()
    {

        $crawler = $this->client->request('GET', '/admin');


        //var_dump($crawler);

        // test qu'on est bien redirigé.
       // $this->assertTrue($this->client->getResponse()->isRedirect());
        //Suivons la redirection
        $crawler = $this->client->followRedirect('/admin/?action=list&entity=User');

     //   $this->assertSame(301, $this->client->getResponse()->getStatusCode());
        $this->assertContains('EasyAdmin', $crawler->text());
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


}