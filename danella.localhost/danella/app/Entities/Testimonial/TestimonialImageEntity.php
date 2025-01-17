<?php

namespace App\Entities\Testimonial;


readonly class TestimonialImageEntity {

    public function __construct (
        public ?int $id,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}