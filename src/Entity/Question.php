<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    use TimestampableEntity;

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
     * @ORM\Column(type="string", length=255)
     */
    private $questionText;

    /**
     * @ORM\Column(type="uuid")
     * @ORM\ManyToOne(targetEntity="App\Entity\Questionnaire")
     */
    private $questionnaireId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionAnswers", mappedBy="question", fetch="EXTRA_LAZY")
     */
    private $answers;

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

    public function getAnswers(): Collection
    {
        return $this->answers;
    }
}
