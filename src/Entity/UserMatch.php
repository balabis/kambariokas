<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserMatchRepository")
 */
class UserMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $firstUser;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $secondUser;

    /**
     * @ORM\Column(type="float")
     */
    private $coeficient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="matchCoefficient")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matchedUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstUser(): ?string
    {
        return $this->firstUser;
    }

    public function setFirstUser(string $firstUser): void
    {
        $this->firstUser = $firstUser;
    }

    public function getSecondUser(): ?string
    {
        return $this->secondUser;
    }

    public function setSecondUser(string $secondUser): void
    {
        $this->secondUser = $secondUser;
    }

    public function getCoefficient(): ?float
    {
        return $this->coeficient;
    }

    public function setCoefficient(float $coefficient): void
    {
        $this->coeficient = $coefficient;
    }

    public function getMatchedUser(): ?User
    {
        return $this->matchedUser;
    }

    public function setMatchedUser(?User $user): self
    {
        $this->matchedUser = $user;

        return $this;
    }
}
