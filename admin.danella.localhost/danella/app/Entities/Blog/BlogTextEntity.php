<?php

namespace App\Entities\Blog;

readonly class BlogTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}