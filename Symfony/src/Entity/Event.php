<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'events')]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $eventDate;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private $location;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $ticketPrice;

    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function getEventDate(): ?\DateTimeInterface { return $this->eventDate; }
    public function setEventDate(\DateTimeInterface $eventDate): self { $this->eventDate = $eventDate; return $this; }
    public function getLocation(): ?Location { return $this->location; }
    public function setLocation(?Location $location): self { $this->location = $location; return $this; }
    public function getTicketPrice(): ?string { return $this->ticketPrice; }
    public function setTicketPrice(?string $ticketPrice): self { $this->ticketPrice = $ticketPrice; return $this; }
}