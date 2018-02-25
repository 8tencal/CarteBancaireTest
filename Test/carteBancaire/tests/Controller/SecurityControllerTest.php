<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SecurityControllerTest extends WebTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testGoodLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();

// set some values
        $form['_username'] = 'antoine';
        $form['_password'] = 'test';

// submit the form
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        //Suivons la redirection
        $crawler = $client->followRedirect();


    }

    /**
     * @runInSeparateProcess
     */
    public function testBadLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();

// set some values
        $form['_username'] = 'pierre';
        $form['_password'] = '1234';

// submit the form
        $crawler = $client->submit($form);
        //var_dump($client->getResponse());
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        //$this->assertContains('Mes cartes',$crawler->filter('div')->text());

    }

}