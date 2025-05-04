<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
#[ORM\Table(name: 'participants')]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 100)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 150, unique: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $phone;

    public function getId(): ?int { return $this->id; }
    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(string $firstName): self { $this->firstName = $firstName; return $this; }
    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(string $lastName): self { $this->lastName = $lastName; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }
}