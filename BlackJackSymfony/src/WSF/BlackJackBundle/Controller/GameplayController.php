<?php

namespace WSF\BlackJackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GameplayController extends Controller
{
    /**
     * @Route("/bet")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function betAction()
    {
        return array(
                // ...
            );    }

}
