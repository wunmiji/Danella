<?php

namespace App\Entities\Service;


readonly class ServiceTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}