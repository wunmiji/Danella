<?php

namespace App\Entities\File;

readonly class FileEntity {

    public function __construct (
        public ?int $id,
        public ?string $privateId,
        public ?string $publicId,
        public ?string $name,
        public ?bool $isDirectory,
        public ?string $urlPath,
        public ?string $description,
        public ?string $path,
        public ?string $parentPath,
        public ?bool $isFavourite,
        public ?bool $isTrash,

        public ?string $mimetype,
        public ?string $size,
        public ?string $extension,
        public ?string $lastModified,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

    ) {}

}