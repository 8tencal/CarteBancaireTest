<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/14/17
 * Time: 11:24 PM
 */
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AccueilControllerTest extends WebTestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testAccueil()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/');
        //var_dump($crawler);
        //die();
        echo $crawler->html();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertContains('COUCOU',$crawler->filter('h1')->text());
    }
}