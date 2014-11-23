<?php

namespace WSF\BlackJackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Round
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WSF\BlackJackBundle\Entity\RoundRepository")
 */
class Round
{
    /**
     * @ORM\OneToMany(targetEntity="RevealedCard", mappedBy="round")
     */
    protected $revealedCards;
     /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="rounds")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    protected $game;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="bet", type="bigint")
     */
    private $bet;


    public function __construct()
    {
        $this->revealedCards = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bet
     *
     * @param integer $bet
     * @return Round
     */
    public function setBet($bet)
    {
        $this->bet = $bet;

        return $this;
    }

    /**
     * Get bet
     *
     * @return integer 
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * Set games
     *
     * @param \WSF\BlackJackBundle\Entity\Game $games
     * @return Round
     */
    public function setGame(\WSF\BlackJackBundle\Entity\Game $games = null)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Get games
     *
     * @return \WSF\BlackJackBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->games;
    }

    /**
     * Add revealedCards
     *
     * @param \WSF\BlackJackBundle\Entity\RevealedCard $revealedCards
     * @return Round
     */
    public function addRevealedCard(\WSF\BlackJackBundle\Entity\RevealedCard $revealedCards)
    {
        $this->revealedCards[] = $revealedCards;

        return $this;
    }

    /**
     * Remove revealedCards
     *
     * @param \WSF\BlackJackBundle\Entity\RevealedCard $revealedCards
     */
    public function removeRevealedCard(\WSF\BlackJackBundle\Entity\RevealedCard $revealedCards)
    {
        $this->revealedCards->removeElement($revealedCards);
    }

    /**
     * Get revealedCards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRevealedCards()
    {
        return $this->revealedCards;
    }

    public function is_card_revealed($name)
    {
        foreach ($this->revealedCards as $key => $value) {
            if($value == $name) {
                return true;
            }
        }
        return false;
    }
}
