<?php

namespace App\Entities\Employee;

readonly class EmployeeContactEntity {

    public function __construct (
        public ?int $id,
        public ?string $email,
        public ?string $mobile,
        public ?string $telephone
    ) {}

}