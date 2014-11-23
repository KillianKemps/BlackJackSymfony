<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

use WSF\BlackJackBundle\Entity\Games;
use WSF\BlackJackBundle\Entity\Round;


class PrepareGameController extends Controller
{
     /**
     * @Route("/game/{playerId}")
     * @Template("WSFBlackJackBundle:PrepareGame:preparegame.html.twig")
     */
    public function gameAction($playerId)
    {

        $games = new Games();
        $games->setScore('0');
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');
        $player = $repository->find($playerId);
        $games->setPlayer($player);

        $em = $this->getDoctrine()->getManager();
        $em->persist($games);
        $em->flush();

        $gamesId = $games->getId();

        return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_bet', array('gamesId' => $gamesId, 'playerId' => $playerId)));
    }

    /**
     * @Route("/bet/{playerId}/{gamesId}")
     * @Template("WSFBlackJackBundle:PrepareGame:preparegame.html.twig")
     */
    public function betAction(Request $request, $playerId, $gamesId)
    {

        $playerRepository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');
        $player = $playerRepository->find($playerId);
        $playerWallet = $player->getWallet();

        $round = new Round();
        $round->setBet('100');
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Games');
        $games = $repository->find($gamesId);

        $round->setGames($games);

        $form = $this->createFormBuilder($round)
            ->add('bet', 'integer')
            ->add('save', 'submit', array('label' => 'Play'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($round);
            $em->flush();

            $roundId = $round->getId();
            // return new Response('Created round bet '.$round->getBet());
            return $this->redirect($this->generateUrl('wsf_blackjack_gameplay_play', array('roundId' => $roundId)));

        }

        return array('form' => $form->createView(), 'playerWallet' => $playerWallet);  
    }
}
