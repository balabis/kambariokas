<?php

namespace App\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $questionText;

    /**
     * @ORM\Column(type="uuid")
     */
    private $questionnaireId;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questionnaire", inversedBy="question")
     */
    private $questionnaire;

    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): self
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getQuestionnaireId()
    {
        return $this->questionnaireId;
    }

    public function setQuestionnaireId($questionnaireId): self
    {
        $this->questionnaireId = $questionnaireId;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function setQuestionnaire($questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }
}
