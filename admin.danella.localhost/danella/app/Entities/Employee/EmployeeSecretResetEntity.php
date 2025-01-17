<?php

namespace App\Entities\Employee;

readonly class EmployeeSecretResetEntity {
    
    public function __construct(
        public ?int $id,
        public ?string $token,
        public ?string $expiresAt,
    ) {}
}