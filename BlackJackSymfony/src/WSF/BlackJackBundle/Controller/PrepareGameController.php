<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

use WSF\BlackJackBundle\Entity\Game;
use WSF\BlackJackBundle\Entity\Round;


class PrepareGameController extends Controller
{
     /**
     * @Route("/game/{playerId}")
     * @Template("WSFBlackJackBundle:PrepareGame:preparegame.html.twig")
     */
    public function gameAction($playerId)
    {

        $game = new Game();
        $game->setScore('0');
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');
        $player = $repository->find($playerId);
        $game->setPlayer($player);

        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->flush();

        $gameId = $game->getId();

        return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_bet', array('gameId' => $gameId, 'playerId' => $playerId)));
    }

    /**
     * @Route("/bet/{playerId}/{gameId}")
     * @Template("WSFBlackJackBundle:PrepareGame:preparegame.html.twig")
     */
    public function betAction(Request $request, $playerId, $gameId)
    {

        $playerRepository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');
        $player = $playerRepository->find($playerId);
        $playerWallet = $player->getWallet();

        $round = new Round();
        $round->setBet('100');
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Game');
        $game = $repository->find($gameId);

        $round->setGame($game);

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

    /**
     * @Route("/bank/{roundId}/{status}")
     * @Template("WSFBlackJackBundle:PrepareGame:preparegame.html.twig")
     */
    public function bankAction($roundId, $status)
    {

        $roundRepository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Round');
        $round = $roundRepository->find($roundId);
        $roundBet = $round->getBet();

        $game = $round->getGame();
        $gameId = $game->getId();

        $player = $game->getPlayer();
        $playerId = $player->getId();

        $playerRepository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');
        $player = $playerRepository->find($playerId);

        if($status == "lose"){
            $player->manageWallet(-$roundBet);
            $game->setScore(-$roundBet);
        }
        else if($status == "won"){
            $player->manageWallet($roundBet);
            $game->setScore($roundBet);
        }
        else{

        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->persist($game);
        $em->flush();

        return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_game', array('playerId' => $playerId)));

    }
}
