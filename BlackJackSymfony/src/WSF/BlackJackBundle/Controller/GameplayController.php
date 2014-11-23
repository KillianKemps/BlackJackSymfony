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
     * @Route("/play")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function playAction()
    {
        return array();  
    }

}
