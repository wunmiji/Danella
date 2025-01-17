<?php

namespace App\Entities\Project;


readonly class ProjectGallaryEntity {

    public function __construct (
        public ?int $id,
        public ?int $projectId,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,
        public ?string $fileMimetype,

    ) {}

}