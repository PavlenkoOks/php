<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ORM\Table(name: 'tickets')]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private $event;

    #[ORM\ManyToOne(targetEntity: Participant::class)]
    #[ORM\JoinColumn(name: 'participant_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private $participant;

    #[ORM\Column(type: 'datetime')]
    private $purchaseDate;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $pricePaid;

    public function getId(): ?int { return $this->id; }
    public function getEvent(): ?Event { return $this->event; }
    public function setEvent(?Event $event): self { $this->event = $event; return $this; }
    public function getParticipant(): ?Participant { return $this->participant; }
    public function setParticipant(?Participant $participant): self { $this->participant = $participant; return $this; }
    public function getPurchaseDate(): ?\DateTimeInterface { return $this->purchaseDate; }
    public function setPurchaseDate(\DateTimeInterface $purchaseDate): self { $this->purchaseDate = $purchaseDate; return $this; }
    public function getPricePaid(): ?string { return $this->pricePaid; }
    public function setPricePaid(?string $pricePaid): self { $this->pricePaid = $pricePaid; return $this; }
}