<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionnaireScoreRepository")
 */
class QuestionnaireScore
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid")
     * @ORM\OneToOne(targetEntity="User")
     */
    private $userId;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $sociabilityQuestionnaire;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $socialOpennessQuestionnaire;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $socialFlexibilityQuestionnaire;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, nullable=true)
     */
    private $cleanlinessQuestionnaire;

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

    public function getSociabilityQuestionnaire()
    {
        return $this->sociabilityQuestionnaire;
    }

    public function setSociabilityQuestionnaire($sociabilityQuestionnaire): self
    {
        $this->sociabilityQuestionnaire = $sociabilityQuestionnaire;

        return $this;
    }

    public function getSocialOpennessQuestionnaire()
    {
        return $this->socialOpennessQuestionnaire;
    }

    public function setSocialOpennessQuestionnaire($socialOpennessQuestionnaire): self
    {
        $this->socialOpennessQuestionnaire = $socialOpennessQuestionnaire;

        return $this;
    }

    public function getSocialFlexibilityQuestionnaire()
    {
        return $this->socialFlexibilityQuestionnaire;
    }

    public function setSocialFlexibilityQuestionnaire($socialFlexibilityQuestionnaire): self
    {
        $this->socialFlexibilityQuestionnaire = $socialFlexibilityQuestionnaire;

        return $this;
    }

    public function getCleanlinessQuestionnaire()
    {
        return $this->cleanlinessQuestionnaire;
    }

    public function setCleanlinessQuestionnaire($cleanlinessQuestionnaire): self
    {
        $this->cleanlinessQuestionnaire = $cleanlinessQuestionnaire;

        return $this;
    }
}
