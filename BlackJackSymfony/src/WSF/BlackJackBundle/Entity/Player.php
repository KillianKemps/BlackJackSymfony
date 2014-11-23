<?php

namespace WSF\BlackJackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Player
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WSF\BlackJackBundle\Entity\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="player")
     */
    protected $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="wallet", type="bigint")
     */
    private $wallet;


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
     * Set name
     *
     * @param string $name
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set wallet
     *
     * @param integer $wallet
     * @return Player
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Get wallet
     *
     * @return integer 
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * Add games
     *
     * @param \WSF\BlackJackBundle\Entity\Game $game
     * @return Player
     */
    public function addGame(\WSF\BlackJackBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove games
     *
     * @param \WSF\BlackJackBundle\Entity\Game $game
     */
    public function removeGame(\WSF\BlackJackBundle\Entity\Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGames()
    {
        return $this->games;
    }
}
