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
        $repository = $this->getDoctrine()
    ->getRepository('WSFBlackJackBundle:Player');


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
        return array(
                // ...
            );    }

}
