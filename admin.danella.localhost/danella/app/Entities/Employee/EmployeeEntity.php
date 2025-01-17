<?php

namespace App\Entities\Employee;

readonly class EmployeeEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $description,

        public ?string $createdDateTime,
        public ?string $modifiedDateTime,

        public ?EmployeeImageEntity $image,
        public ?EmployeeContactEntity $contact,
        public ?EmployeeSecretEntity $secret
    ) {}

}