<?php

namespace WSF\BlackJackBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommunityControllerTest extends WebTestCase
{
    public function testShowlistplayers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ShowListPlayers');
    }

    public function testShowplayerprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ShowPlayerProfile');
    }

}
