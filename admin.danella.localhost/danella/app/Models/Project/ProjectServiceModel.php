<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class ProjectServiceModel extends Model
{

    protected $table = 'project_service';
    protected $primaryKey = 'ProjectServiceId';
    protected $allowedFields = ['ProjectServiceId', 'ProjectServiceProjectFk', 'ProjectServiceServiceFk'];

    // SQL
    protected $sqlService = 'SELECT
                            ps.ProjectServiceId AS Id,
                            ps.ProjectServiceProjectFk AS ProjectId,
                            ps.ProjectServiceServiceFk AS ServiceId,
                            s.ServiceName 
                        FROM
                            project_service ps
                            JOIN service s ON s.ServiceId = ps.ProjectServiceServiceFk 
                        WHERE
                            ps.ProjectServiceProjectFk = :projectId:;';



}
