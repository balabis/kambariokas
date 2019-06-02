<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionnaireScoreRepository")
 */
class QuestionnaireScore
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid")
     */
    private $userId;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $sociability;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $socialOpenness;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $socialFlexibility;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $cleanliness;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="questionnaireScore")
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getSociability()
    {
        return $this->sociability;
    }

    public function setSociability($sociability): self
    {
        $this->sociability = $sociability;

        return $this;
    }

    public function getSocialOpenness()
    {
        return $this->socialOpenness;
    }

    public function setSocialOpenness($socialOpenness): self
    {
        $this->socialOpenness = $socialOpenness;

        return $this;
    }

    public function getSocialFlexibility()
    {
        return $this->socialFlexibility;
    }

    public function setSocialFlexibility($socialFlexibility): self
    {
        $this->socialFlexibility = $socialFlexibility;

        return $this;
    }

    public function getCleanliness()
    {
        return $this->cleanliness;
    }

    public function setCleanliness($cleanliness): self
    {
        $this->cleanliness = $cleanliness;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        // set the owning side of the relation if necessary
        if ($this !== $user->getQuestionnaireScore()) {
            $user->setQuestionnaireScore($this);
        }

        return $this;
    }
}
