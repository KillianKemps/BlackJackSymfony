<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use WSF\BlackJackBundle\Entity\Round;


class GameplayController extends Controller
{
    /**
     * @Route("/bet")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function betAction(Request $request)
    {
        $round = new Round();
        $round->setBet('100');

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
