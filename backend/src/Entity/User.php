<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface
{
    public function __construct(string $email)
    {
        $this->id = null;
        $this->email = $email;
        $this->updated = new DateTimeImmutable();
        $this->created = new DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\Column(name: 'user_id', type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id;

    #[ORM\Column(name: 'user_email', type: 'string')]
    private string $email;

    #[ORM\Column(name: 'user_created', type: 'datetime_immutable')]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'user_updated', type: 'datetime_immutable')]
    private DateTimeImmutable $updated;

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    #[ORM\PrePersist]
    public function setCreated(): void
    {
        $this->created = new DateTimeImmutable();
        $this->setUpdated();
    }

    #[ORM\PreUpdate]
    public function setUpdated(): void
    {
        $this->updated = new DateTimeImmutable();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function getRoles(): array
    {
        return ["ROLE_USER"];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}