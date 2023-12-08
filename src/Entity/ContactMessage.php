<?php

namespace App\Entity;

use App\Repository\ContactMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactMessageRepository::class)]
class ContactMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private string $message;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column]
    private bool $processed = false;

    #[ORM\ManyToOne(targetEntity: ContactUser::class, inversedBy: 'messages', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ContactUser $contactUser;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isProcessed(): bool
    {
        return $this->processed;
    }

    public function setProcessed(bool $processed): static
    {
        $this->processed = $processed;

        return $this;
    }

    public function jsonSerialize(): string
    {
        $data = array(
            'id' => $this->getId(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'firstname' => $this->getContactUser()->getFirstname(),
            'lastname' => $this->getContactUser()->getLastname(),
            'email' => $this->getContactUser()->getEmail(),
            'message' => $this->getMessage(),
        );

        $json = json_encode($data);
        return $json;
    }

    public function getContactUser(): ?ContactUser
    {
        return $this->contactUser;
    }

    public function setContactUser(?ContactUser $contactUser): static
    {
        $this->contactUser = $contactUser;

        return $this;
    }
}
