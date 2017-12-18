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
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('submit')->form();

// set some values
        $form['username'] = 'antoine';
        $form['password'] = 'test';

// submit the form
        $crawler = $client->submit($form);

    }

    public function testBadLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('submit')->form();

// set some values
        $form['username'] = 'pierre';
        $form['password'] = '1234';

// submit the form
        $crawler = $client->submit($form);

    }

}