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
     * @Route("/play/{roundId}/{playerValue}/{bankValue}", defaults={"bankValue" = 0, "playerValue" = 0})
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function playAction($roundId, $playerValue, $bankValue)
    {
        $canPlay = false;
        if($playerValue > 21){
            $message = "You lose. ";
            $status = "lose";
            // return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_bank', array('roundId' => $roundId, 'status' => "lose")));
        }
        else{
            if($bankValue > 21 && $bankValue != 0){
                $message = "You won your bet. Bank had " . $bankValue;
                $status = "won";
                // return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_bank', array('roundId' => $roundId, 'status' => "won")));

            }
            else if($playerValue > $bankValue && $bankValue != 0){
                $message = "You won double your bet. Bank had " . $bankValue;
                $status = "double";
                // return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_bank', array('roundId' => $roundId, 'status' => "double")));

            }
            else if($playerValue < $bankValue && $bankValue != 0){
                $message = "You lose your bet. Bank had " . $bankValue;
                $status = "lose";
                // return $this->redirect($this->generateUrl('wsf_blackjack_preparegame_bank', array('roundId' => $roundId, 'status' => "lose")));
            }
            else{
                $canPlay = true;
                $message = "You still can win.";
                $status = "none";
            }    
        }

        return array('message' => $message, 'playerValue' => $playerValue, 'roundId' => $roundId, 'canPlay' => $canPlay, 'status' => $status);  
    }

    /**
     * @Route("/playBank/{roundId}/{playerValue}")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function bankPlayAction($roundId, $playerValue){
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


        function checkIfCardAlreadyExists($revealedCards, $randomCard){
            $totalRevealedCardsValue = 0;
            for ($i=0; $i < sizeof($revealedCards); $i++) {
                if($revealedCards[$i]['name'] == $randomCard){
                    echo "card already exist";
                    $randomCard = takeCard();
                    checkIfCardAlreadyExists($revealedCards, $randomCard); 
                } 
                $totalRevealedCardsValue += substr($revealedCards[$i]['name'], 0, -1); 
            }    
            return $totalRevealedCardsValue;
        }
        $bankValue = 0;

        while($bankValue < 17){
            $randomCard = takeCard();        

            // Get the cards already played
            $repository = $this->getDoctrine()
                ->getRepository('WSFBlackJackBundle:Round');
            $round = $repository->find($roundId);

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT p
                FROM WSFBlackJackBundle:RevealedCard p
                WHERE p.round = :roundId'
            )->setParameter('roundId', $roundId);

            $revealedCards = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

            // Check if the taken card were already taken   
            // In the same time, calculates the total value of the revealed cards     
            checkIfCardAlreadyExists($revealedCards, $randomCard);

             // Get the value of the taken card
            $cardValue = substr($randomCard, 0, 2); 

            // Calculates the total value with the taken card
            $bankValue = $bankValue + $cardValue;

            // Saves the unique card to the database
            $revealedCard = new RevealedCard();
            $revealedCard->setName($randomCard);
            $revealedCard->setRound($round);

            $em->persist($revealedCard);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('wsf_blackjack_gameplay_play', array('roundId' => $roundId, 'playerValue' => $playerValue, 'bankValue' => $bankValue)));
    }

    /**
     * @Route("/playPlayer/{roundId}/{playerValue}")
     * @Template("WSFBlackJackBundle:Gameplay:gameplay.html.twig")
     */
    public function playerPlayAction($roundId, $playerValue){
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


        function checkIfCardAlreadyExists($revealedCards, $randomCard){
            $totalRevealedCardsValue = 0;
            for ($i=0; $i < sizeof($revealedCards); $i++) {
                if($revealedCards[$i]['name'] == $randomCard){
                    echo "card already exist";
                    $randomCard = takeCard();
                    checkIfCardAlreadyExists($revealedCards, $randomCard); 
                } 
                $totalRevealedCardsValue += substr($revealedCards[$i]['name'], 0, -1); 
            }    
            return $totalRevealedCardsValue;
        }

        $randomCard = takeCard();        

        // Get the cards already played
        $repository = $this->getDoctrine()
            ->getRepository('WSFBlackJackBundle:Round');
        $round = $repository->find($roundId);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM WSFBlackJackBundle:RevealedCard p
            WHERE p.round = :roundId'
        )->setParameter('roundId', $roundId);

        $revealedCards = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        // Check if the taken card were already taken   
        // In the same time, calculates the total value of the revealed cards     
        checkIfCardAlreadyExists($revealedCards, $randomCard);

         // Get the value of the taken card
        $cardValue = substr($randomCard, 0, 2); 

        // Calculates the total value with the taken card
        $playerValue = $playerValue + $cardValue;

        // Saves the unique card to the database
        $revealedCard = new RevealedCard();
        $revealedCard->setName($randomCard);
        $revealedCard->setRound($round);

        $em->persist($revealedCard);
        $em->flush();

        return $this->redirect($this->generateUrl('wsf_blackjack_gameplay_play', array('roundId' => $roundId, 'playerValue' => $playerValue)));
    }

}
