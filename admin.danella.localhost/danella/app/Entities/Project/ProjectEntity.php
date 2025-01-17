<?php

namespace App\Entities\Project;


readonly class ProjectEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $slug,
        public ?string $status,
        public ?string $location,
        public ?string $date,
        public ?string $client,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?ProjectTextEntity $text,
        public ?ProjectImageEntity $image,
        public ?array $services,
        public ?array $gallary,
        public ?array $files,

    ) {}

}