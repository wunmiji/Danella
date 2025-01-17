<?php

namespace App\Entities\Blog;


readonly class BlogAuthorEntity {

    public function __construct (
        public ?int $id,
        public ?int $authorId,
        public ?string $name,
        public ?string $description,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}