<?php

namespace App\Entities\Project;


readonly class ProjectEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $slug,
        public ?string $location,
        public ?string $date,
        public ?string $client,

        public ?ProjectImageEntity $image,
        public ?ProjectTextEntity $text,
        public ?array $services,
        public ?array $gallary,

    ) {}

}