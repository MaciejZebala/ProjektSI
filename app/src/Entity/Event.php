<?php
/**
 * Event Entity
 */

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Event
 *
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ORM\Table("events")
 *
 * @UniqueEntity(fields={"title"})
 */
class Event
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="date")
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @Assert\DateTime
     */
    private $date;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=70,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="70",
     * )
     */
    private $title;

    /**
     * Category
     *
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="events")
     */
    private $category;

    /**
     * Contact
     *
     * @ORM\ManyToMany(targetEntity=Contact::class, inversedBy="events")
     * @ORM\JoinTable(name="events_contacts")
     *
     */
    private $contact;

    /**
     * Tag
     *
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="events", orphanRemoval=true)
     * @ORM\JoinTable(name="events_tags")
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
     * Event constructor.
     */
    public function __construct()
    {
        $this->contact = new ArrayCollection();
        $this->tag = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Date.
     *
     * @return \DateTimeInterface|null Date
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for Date.
     *
     * @param DateTimeInterface $date Date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact): void
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
        }
    }

    /**
     * @param Contact $contact
     */
    public function removeContact(Contact $contact): void
    {
        if ($this->contact->contains($contact)) {
            $this->contact->removeElement($contact);
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
