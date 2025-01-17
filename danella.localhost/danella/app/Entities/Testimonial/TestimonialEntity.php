<?php

namespace App\Entities\Testimonial;


readonly class TestimonialEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $note,
        public ?string $position,
        
        public ?TestimonialImageEntity $image,

    ) {}

}