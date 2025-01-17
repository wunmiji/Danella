<?php

namespace App\Entities\Service;


readonly class ServiceEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $slug,
        public ?string $description,
        public ?string $status,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?ServiceImageEntity $image,
        public ?ServiceTextEntity $text,
        public ?array $faqs,

    ) {}

}