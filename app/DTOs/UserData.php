<?php

namespace App\DTOs;

class UserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly ?string $phone = null,
        public readonly ?string $designation = null,
        public readonly ?int $company_id = null,
        public readonly ?array $permissions = null,
        public readonly string $timezone = 'Asia/Kolkata'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            phone: $data['phone'] ?? null,
            designation: $data['designation'] ?? null,
            company_id: $data['company_id'] ?? null,
            permissions: $data['permissions'] ?? null,
            timezone: $data['timezone'] ?? 'Asia/Kolkata'
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'designation' => $this->designation,
            'company_id' => $this->company_id,
            'permissions' => $this->permissions,
            'timezone' => $this->timezone,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        return array_filter($data, fn($value) => $value !== null);
    }
}