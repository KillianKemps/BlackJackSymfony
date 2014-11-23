<?php

namespace WSF\BlackJackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RevealedCard
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RevealedCard
{
     /**
     * @ORM\ManyToOne(targetEntity="WSF\BlackJackBundle\Entity\Round", inversedBy="revealedCards")
     * @ORM\JoinColumn(name="round_id", referencedColumnName="id")
     */
    protected $round;

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
     * @return RevealedCard
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
     * Set round
     *
     * @param \WSF\BlackJackBundle\Entity\Round $round
     * @return RevealedCard
     */
    public function setRound(\WSF\BlackJackBundle\Entity\Round $round = null)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return \WSF\BlackJackBundle\Entity\Round 
     */
    public function getRound()
    {
        return $this->round;
    }
}
