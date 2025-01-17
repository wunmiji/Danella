<?php

namespace App\Entities\Testimonial;


readonly class TestimonialEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $status,
        public ?string $note,
        public ?string $position,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?TestimonialImageEntity $image,

    ) {}

}