<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class ProjectTextModel extends Model
{

    protected $table = 'project_text';
    protected $primaryKey = 'ProjectId';
    protected $allowedFields = ['ProjectId', 'ProjectText'];

    // SQL
    protected $sqlText = 'SELECT
                            ProjectId,
                            ProjectText
                        FROM
                        project_text 
                        WHERE
                            ProjectId = :projectId:;';



}
