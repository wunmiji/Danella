<?php

namespace App\Entities\FileManager;

readonly class FileManagerFileEntity {

    public function __construct (
        public ?int $id,
        public ?string $path,
        public ?string $filePath,
        public ?string $fileSrc,
        public ?string $fileName,
        public ?string $fileMimetype,
        public ?string $fileSize,
        public ?string $fileExtension,
        public ?string $fileLastModified,

        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime

    ) {}

}