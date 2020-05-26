<?php

namespace App\Entity;

use DateTimeInterface;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//@ORM\Entity(repositoryClass=EventRepository::class)
/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ORM\Table("events")
 */
class Event
{
    /**
     * Primary key
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Date
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * Title
     *
     * @var string
     *
     * @ORM\Column(type="string", length=70)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Contact::class, inversedBy="events")
     */
    private $contact;

    public function __construct()
    {
        $this->contact = new ArrayCollection();
    }

    /**
     * Getter for Id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Date
     *
     * @return DateTimeInterface|null
     */

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for Date
     *
     * @param DateTimeInterface $date Date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;

    }

    /**
     * Getter for Title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title
     *
     * @param string $title Title
     */

    public function setTitle(string $title): void
    {
        $this->title = $title;

    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contact->contains($contact)) {
            $this->contact->removeElement($contact);
        }

        return $this;
    }
}
