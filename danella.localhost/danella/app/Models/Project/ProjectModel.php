<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class ProjectModel extends Model
{

    protected $table = 'project';
    protected $primaryKey = 'ProjectId';
    protected $allowedFields = [
        'ProjectId',
        'ProjectName',
        'ProjectStatus',
        'ProjectSlug',
        'ProjectLocation',
        'ProjectDate',
        'ProjectClient',
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(ProjectId) AS COUNT FROM project WHERE ProjectStatus = true';
    protected $sqlSlug = 'SELECT
                            ProjectId,
                            ProjectName,
                            ProjectStatus,
                            ProjectSlug,
                            ProjectLocation,
                            ProjectDate,
                            ProjectClient
                        FROM
                            project 
                        WHERE 
                            ProjectSlug = :slug: 
                            AND
                            ProjectStatus = true;';

    protected $sqlList = 'SELECT
                            ProjectId,
                            ProjectName,
                            ProjectSlug
                        FROM
                            project 
                        WHERE 
                            ProjectStatus = true 
                        ORDER BY 
                            ProjectId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';




}
