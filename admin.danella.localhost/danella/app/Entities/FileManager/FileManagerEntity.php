<?php

namespace App\Entities\FileManager;

readonly class FileManagerEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $type,
        public ?string $typeValue,
        public ?string $urlPath,
        public ?string $description,
        public ?string $path,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?array $files,

    ) {}

}