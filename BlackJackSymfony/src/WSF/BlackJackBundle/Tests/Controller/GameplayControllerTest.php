<?php

namespace WSF\BlackJackBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameplayControllerTest extends WebTestCase
{
    public function testBet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bet');
    }

}
