<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

use WSF\BlackJackBundle\Entity\RevealedCard;

class GameplayController extends Controller
{
    /**
     * @Route("/play/{roundId}")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function playAction($roundId)
    {
        function takeCard(){
            $cardsArray = array(
                '1A', '2A', '3A', '4A', '5A', '6A', '7A', '8A', '9A', '10A', '11A', '12A', '13A',
                '1B', '2B', '3B', '4B', '5B', '6B', '7B', '8B', '9B', '10B', '11B', '12B', '13B',
                '1C', '2C', '3C', '4C', '5C', '6C', '7C', '8C', '9C', '10C', '11C', '12C', '13C',
                '1D', '2D', '3D', '4D', '5D', '6D', '7D', '8D', '9D', '10D', '11D', '12D', '13D'
            );

            $randomCard = $cardsArray[array_rand($cardsArray, 1)];

            return $randomCard;
        }

        $randomCard = takeCard();        

        $revealedCard = new RevealedCard();
        $revealedCard->setName($randomCard);

        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Round');
        $round = $repository->find($roundId);
        $revealedCard->setRound($round);

        $em = $this->getDoctrine()->getManager();
        $em->persist($revealedCard);
        $em->flush();

        return array();  
    }

}
