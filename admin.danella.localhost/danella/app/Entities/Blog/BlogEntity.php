<?php

namespace App\Entities\Blog;

readonly class BlogEntity {

    public function __construct (
        public ?int $id,
        public ?string $title,
        public ?string $slug,
        public ?string $summary,
        public ?string $status,
        public ?string $publishedDate,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?BlogImageEntity $image,
        public ?BlogTextEntity $text,
        public ?BlogAuthorEntity $author,
        public ?array $categories,

    ) {}

}