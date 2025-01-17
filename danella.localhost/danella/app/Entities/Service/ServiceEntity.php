<?php

namespace App\Entities\Service;


readonly class ServiceEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $slug,
        public ?string $description,

        public ?ServiceImageEntity $image,
        public ?ServiceTextEntity $text,
        public ?array $faqs,

    ) {}

}