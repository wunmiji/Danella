<?php

namespace App\Entities\Project;


readonly class ProjectServiceEntity {

    public function __construct (
        public ?int $id,
        public ?int $projectId,
        public ?int $serviceId,
        public ?string $name,


    ) {}

}