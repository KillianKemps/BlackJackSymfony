<?php

namespace WSF\BlackJackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Games
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WSF\BlackJackBundle\Entity\GameRepository")
 */
class Game
{
    /**
     * @ORM\OneToMany(targetEntity="Round", mappedBy="game")
     */
    protected $rounds;

    public function __construct()
    {
        $this->rounds = new ArrayCollection();
    }

     /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="games")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;

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
     * @ORM\Column(name="score", type="bigint")
     */
    private $score;


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
     * Set score
     *
     * @param integer $score
     * @return Games
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Add rounds
     *
     * @param \WSF\BlackJackBundle\Entity\Round $rounds
     * @return Games
     */
    public function addRound(\WSF\BlackJackBundle\Entity\Round $rounds)
    {
        $this->rounds[] = $rounds;

        return $this;
    }

    /**
     * Remove rounds
     *
     * @param \WSF\BlackJackBundle\Entity\Round $rounds
     */
    public function removeRound(\WSF\BlackJackBundle\Entity\Round $rounds)
    {
        $this->rounds->removeElement($rounds);
    }

    /**
     * Get rounds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Set player
     *
     * @param \WSF\BlackJackBundle\Entity\Player $player
     * @return Games
     */
    public function setPlayer(\WSF\BlackJackBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \WSF\BlackJackBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
