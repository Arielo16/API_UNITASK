<?php

namespace App\Core\Entities;

class User
{
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private ?string $email_verified_at = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->email_verified_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'email_verified_at' => $this->email_verified_at
        ];
    }
} 