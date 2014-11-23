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


class GameplayController extends Controller
{
     /**
     * @Route("/game/{playerId}")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function gameAction($playerId)
    {

        $games = new Games();
        $games->setScore('0');
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Player');
        $player = $repository->find($playerId);
        $games->setPlayer($player);
        var_dump($playerId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($games);
        $em->flush();

        $gamesId = $games->getId();

        // $response = $this->forward('WSFBlackJackBundle:Gameplay:bet', array(
        //     'games'  => $games,
        // ));

        // // ... modifiez encore la réponse ou bien retournez-la directement

        // return $response;

        return $this->redirect($this->generateUrl('wsf_blackjack_gameplay_bet', array('gamesId' => $gamesId)));
    }

    /**
     * @Route("/bet/{gamesId}")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function betAction(Request $request, $gamesId)
    {
        // $response = new Response('Content', 200, array('content-type' => 'text/html'));
        // $request = $this->getRequest();
        // $cookies = $request->cookies->all();    
        // // $request = $this->getRequest($_COOKIE);
        // $playerId = $request->headers->getCookies();
        // $playerId = $response->headers->getCookies();
        // var_dump($cookies);
    //     $repository = $this->getDoctrine()
    // ->getRepository('WSFBlackJackBundle:Player');
    //     $player = $repository->find($playerId);
    //     $playerWallet = $player->getWallet();

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
            return new Response('Created round bet '.$round->getBet());
        }

        return array('form' => $form->createView());  
    }

    /**
     * @Route("/play")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function playAction()
    {
        return array(
                // ...
            );    
    }

    /**
     * @Route("/createGame")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function createGameAction()
    {
        return array(
                // ...
            );    
    }

    /**
     * @Route("/createRound")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function createRoundAction()
    {
        return array(
                // ...
            );    
    }

}
