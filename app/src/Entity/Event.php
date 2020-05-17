<?php

namespace App\Entity;

use DateTimeInterface;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

//@ORM\Entity(repositoryClass=EventRepository::class)
/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
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
     * @ORM\Column(type="datetime")
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
}
