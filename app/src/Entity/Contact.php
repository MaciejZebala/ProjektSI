<?php

/**
 * Contact Entity
 */
namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact Class
 *
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(name="contacts")
 */
class Contact
{
    /**
     * Primary Key
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name
     *
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $name;

    /**
     * Surname
     *
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $surname;

    /**
     * PhoneNumber
     *
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="8",
     *     max="20",
     * )
     */
    private $phoneNumber;

    /**
     * Email
     *
     * @var string
     *
     * @ORM\Column(type="string", length=65)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="6",
     *     max="65",
     * )
     */
    private $email;

    /**
     * Events
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Event[]    $events Events
     *
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="contact")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $events;

    /**
     * Tag
     *
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="contacts")
     * @ORM\JoinTable(name="contacts_tags")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $tag;

    /**
     * User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Contact constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->tag = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @param Event $event
     */
    public function addEvent(Event $event): void
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addContact($this);
        }
    }

    /**
     * @param Event $event
     */
    public function removeEvent(Event $event): void
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeContact($this);
        }
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
