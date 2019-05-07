<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
 * @ORM\Table(name="user")
*/
class UpdateUserRequest
{
    use TimestampableEntity;
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
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

    public static function fromUser(User $user): self
    {
        $userRequest = new self();
        $userRequest->id = $user->getId();
        $userRequest->gender = $user->getGender();
        $userRequest->profilePicture = $user->getProfilePicture();
        $userRequest->dateOfBirth = $user->getDateOfBirth();
        $userRequest->fullName = $user->getFullName();
        $userRequest->city = $user->getCity();
        $userRequest->aboutme = $user->getAboutme();
        $userRequest->email = $user->getEmail();
        $userRequest->roles = $user->getRoles();
        $userRequest->password = $user->getPassword();
        $userRequest->createdAt = $user->getCreatedAt();
        $userRequest->updatedAt = new \DateTime();

        return $userRequest;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }


    public function setDateOfBirth($dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    public function getAboutme()
    {
        return $this->aboutme;
    }

    public function setAboutme($aboutme): void
    {
        $this->aboutme = $aboutme;
    }
}
