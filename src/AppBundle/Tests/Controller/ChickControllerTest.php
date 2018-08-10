<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChickControllerTest extends WebTestCase
{
    public function testViewall()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/chicks');
    }

    public function testViewchick()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/chick/{id}');
    }

}
