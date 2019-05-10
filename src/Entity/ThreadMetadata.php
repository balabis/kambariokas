<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\ThreadMetadata as BaseThreadMetadata;

/**
 * @ORM\Entity
 */
class ThreadMetadata extends BaseThreadMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="App\Entity\Thread",
     *   inversedBy="metadata"
     * )
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected $participant;
}