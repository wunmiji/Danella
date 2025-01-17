<?php

namespace App\Entities\Blog;

readonly class BlogCategoryEntity {

    public function __construct (
        public ?int $id,
        public ?int $blogId,
        public ?int $categoryId,
        public ?string $name,


    ) {}

}