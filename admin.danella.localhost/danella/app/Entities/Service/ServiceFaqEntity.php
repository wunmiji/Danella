<?php

namespace App\Entities\Service;


readonly class ServiceFaqEntity {

    public function __construct (
        public ?int $id,
        public ?int $serviceId,
        public ?string $question,
        public ?string $answer

    ) {}

}