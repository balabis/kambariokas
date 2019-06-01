<?php

namespace App\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Notifiable(name="User")
 */
class User implements UserInterface, ParticipantInterface, NotifiableInterface
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
     * @ORM\OneToMany(targetEntity="App\Entity\Invite", mappedBy="sender")
     */
    private $invitesSentTo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invite", mappedBy="receiver")
     */
    private $receivedInvitesFrom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="100")
     */
    private $cityPart;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $occupation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $hobbies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="100")
     */
    private $university;

    /**
     * @ORM\Column(type="datetime", name="last_activity_at", nullable=true)
     */
    private $lastActivityAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    public function __construct()
    {
        $this->invitesSentTo = new ArrayCollection();
        $this->receivedInvitesFrom = new ArrayCollection();
    }

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

    /**
     * @return Collection|Invite[]
     */
    public function getInvitesSentTo(): Collection
    {
        return $this->invitesSentTo;
    }

    public function addInvitesSentTo(Invite $invitesSentTo): self
    {
        if (!$this->invitesSentTo->contains($invitesSentTo)) {
            $this->invitesSentTo[] = $invitesSentTo;
            $invitesSentTo->setSender($this);
        }

        return $this;
    }

    public function removeInvitesSentTo(Invite $invitesSentTo): self
    {
        if ($this->invitesSentTo->contains($invitesSentTo)) {
            $this->invitesSentTo->removeElement($invitesSentTo);
            // set the owning side to null (unless already changed)
            if ($invitesSentTo->getSender() === $this) {
                $invitesSentTo->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invite[]
     */
    public function getReceivedInvitesFrom(): Collection
    {
        return $this->receivedInvitesFrom;
    }

    public function addReceivedInvitesFrom(Invite $receivedInvitesFrom): self
    {
        if (!$this->receivedInvitesFrom->contains($receivedInvitesFrom)) {
            $this->receivedInvitesFrom[] = $receivedInvitesFrom;
            $receivedInvitesFrom->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedInvitesFrom(Invite $receivedInvitesFrom): self
    {
        if ($this->receivedInvitesFrom->contains($receivedInvitesFrom)) {
            $this->receivedInvitesFrom->removeElement($receivedInvitesFrom);
            // set the owning side to null (unless already changed)
            if ($receivedInvitesFrom->getReceiver() === $this) {
                $receivedInvitesFrom->setReceiver(null);
            }
        }

        return $this;
    }

    public function getCityPart(): ?string
    {
        return $this->cityPart;
    }

    public function setCityPart(?string $cityPart): self
    {
        $this->cityPart = $cityPart;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): self
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getHobbies(): ?string
    {
        return $this->hobbies;
    }

    public function setHobbies(?string $hobbies): self
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    public function getUniversity(): ?string
    {
        return $this->university;
    }

    public function setUniversity(?string $university): self
    {
        $this->university = $university;

        return $this;
    }

    public function setLastActivityAt($lastActivityAt)
    {
        $this->lastActivityAt = $lastActivityAt;
    }

    public function getLastActivityAt()
    {
        return $this->lastActivityAt;
    }

    public function isActiveNow()
    {
        // Delay during which the user will be considered as still active
        $delay = new \DateTime('2 minutes ago');

        return $this->getLastActivityAt() > $delay;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
