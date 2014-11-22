<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use WSF\BlackJackBundle\Entity\Player;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template("WSFBlackJackBundle:Default:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $player = new Player();
        $player->setName('Player name');
        $player->setWallet('10000');

        $form = $this->createFormBuilder($player)
            ->add('name', 'text')
            ->add('save', 'submit', array('label' => 'Play'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            return $this->redirect($this->generateUrl('wsf_blackjack_gameplay_bet'));
        }

        $repository = $this->getDoctrine()
    ->getRepository('WSFBlackJackBundle:Player');

        $bestplayers = $repository->findBy(
            array(),
            array('wallet' => 'DESC'),
            5
        );  

        return array('form' => $form->createView(), 'bestplayers' => $bestplayers);
    }
}
