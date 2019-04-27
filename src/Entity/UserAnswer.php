<?php

namespace App\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAnswerRepository")
 */
class UserAnswer
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
     * @ORM\Column(type="uuid")
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     */
    private $questionId;

    /**
     * @ORM\Column(type="uuid")
     * @ORM\ManyToOne(targetEntity="QuestionAnswers.php")
     */
    private $questionAnswerId;

    /**
     * @ORM\Column(type="uuid")
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userId;

    public function getId()
    {
        return $this->id;
    }

    public function getQuestionId(): ?int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): self
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getQuestionAnswerId(): ?int
    {
        return $this->questionAnswerId;
    }

    public function setQuestionAnswerId(int $questionAnswerId): self
    {
        $this->questionAnswerId = $questionAnswerId;

        return $this;
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
}
