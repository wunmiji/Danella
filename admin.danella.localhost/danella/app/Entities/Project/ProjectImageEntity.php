<?php

namespace App\Entities\Project;


readonly class ProjectImageEntity {

    public function __construct (
        public ?int $id,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}