<?php

namespace App\Entities\Employee;

readonly class EmployeeSecretEntity {
    
    public function __construct(
        public ?int $id,
        public ?string $salt,
        public ?string $password,
    ) {}
}