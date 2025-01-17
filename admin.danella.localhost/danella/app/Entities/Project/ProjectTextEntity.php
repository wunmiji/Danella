<?php

namespace App\Entities\Project;


readonly class ProjectTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}