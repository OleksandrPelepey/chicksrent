<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerControllerTest extends WebTestCase
{
    public function testRegisteruser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
    }

    public function testLoginuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
    }

    public function testResetpassword()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reset-password');
    }

}
