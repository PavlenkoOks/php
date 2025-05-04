<?php

namespace App\Entity;

use App\Repository\EventOrganizerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventOrganizerRepository::class)]
#[ORM\Table(name: "event_organizers")]
class EventOrganizer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $name;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $phone;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private $event;

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): self { $this->email = $email; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }
    public function getEvent(): ?Event { return $this->event; }
    public function setEvent(?Event $event): self { $this->event = $event; return $this; }
}