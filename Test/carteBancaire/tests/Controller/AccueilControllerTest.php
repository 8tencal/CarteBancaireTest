<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/14/17
 * Time: 11:24 PM
 */
namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccueilControllerTest extends WebTestCase
{
    public function testAccueil()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertContains('COUCOU',$crawler->filter('#container h1')->text());
    }
}