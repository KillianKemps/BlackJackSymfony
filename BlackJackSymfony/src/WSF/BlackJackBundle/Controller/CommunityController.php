<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CommunityController extends Controller
{
    /**
     * @Route("/ShowListPlayers")
     * @Template()
     */
    public function ShowListPlayersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $players = $em->createQuery(
                'SELECT p FROM WSFBlackJackBundle:Player p ORDER BY p.wallet DESC'
            )
            ->getResult();

        return array('players' => $players);
    }

    /**
     * @Route("/ShowPlayerProfile/{playerId}")
     * @Template()
     */
    public function ShowPlayerProfileAction($playerId)
    {
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');

        $player = $repository->find($playerId);
        
        $games = $player->getGames();

        return array('player' => $player, 'games' => $games);
    }

}
