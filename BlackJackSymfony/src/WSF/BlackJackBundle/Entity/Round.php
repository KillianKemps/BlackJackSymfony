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
     * @ORM\OneToMany(targetEntity="RevealedCard", mappedBy="Round")
     */
    protected $revealedCards;

    public function __construct()
    {
        $this->revealedCards = new ArrayCollection();
    }

     /**
     * @ORM\ManyToOne(targetEntity="Games", inversedBy="rounds")
     * @ORM\JoinColumn(name="games_id", referencedColumnName="id")
     */
    protected $games;

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
     * @param \WSF\BlackJackBundle\Entity\Games $games
     * @return Round
     */
    public function setGames(\WSF\BlackJackBundle\Entity\Games $games = null)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Get games
     *
     * @return \WSF\BlackJackBundle\Entity\Games 
     */
    public function getGames()
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
}
