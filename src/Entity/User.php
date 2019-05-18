<?php

namespace App\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, ParticipantInterface
{
    use TimestampableEntity;
    /**
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $profilePicture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $aboutme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\QuestionnaireScore", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $questionnaireScore;

    /**
     * @return mixed
     */
    public function getAboutme()
    {
        return $this->aboutme;
    }

    /**
     * @param mixed $aboutme
     */
    public function setAboutme($aboutme): void
    {
        $this->aboutme = $aboutme;
    }

    /**
     * @return mixed
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param mixed $profilePicture
     */
    public function setProfilePicture($profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getQuestionnaireScore(): ?QuestionnaireScore
    {
        return $this->questionnaireScore;
    }

    public function setQuestionnaireScore(QuestionnaireScore $questionnaireScore): self
    {
        $this->questionnaireScore = $questionnaireScore;

        return $this;
    }

    public function getUserAge()
    {
        if (isset($this->dateOfBirth)) {
            $today = date('Y-m-d');
            $dateOfBirth = $this->dateOfBirth->format('Y-m-d');
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            return $diff->format('%y');
        }

        return null;
    }
}
