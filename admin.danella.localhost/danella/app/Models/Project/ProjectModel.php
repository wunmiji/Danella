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
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(ProjectId) AS COUNT FROM project';
    protected $sqlDelete = 'DELETE FROM project WHERE ProjectId = :projectId:;';
    protected $sqlStatus = 'SELECT ProjectStatus FROM project WHERE ProjectId = :projectId:;';
    protected $sqlTable = 'SELECT
                            ProjectId,
                            ProjectName,
                            ProjectClient,
                            ProjectStatus
                        FROM
                            project 
                        ORDER BY 
                            ProjectId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';

    protected $sqlRetrieve = 'SELECT
                            p.ProjectId,
                            p.ProjectName,
                            p.ProjectStatus,
                            p.ProjectSlug,
                            p.ProjectLocation,
                            p.ProjectDate,
                            p.ProjectClient,
                            ce.EmployeeFirstName AS CreatedByFirstName,
                            ce.EmployeeLastName AS CreatedByLastName,
                            p.CreatedDateTime,
                            p.CreatedId,
                            me.EmployeeFirstName AS ModifiedByFirstName,
                            me.EmployeeLastName AS ModifiedByLastName,
                            p.ModifiedDateTime,
                            p.ModifiedId
                        FROM
                            project p
                            JOIN employee ce ON p.CreatedId = ce.EmployeeId
                            LEFT JOIN employee me ON p.ModifiedId = me.EmployeeId
                        WHERE
                            p.ProjectId = :projectId:;';

    protected $projectPerMonth = 'SELECT 
	                                DISTINCT DATE_FORMAT(ProjectDate, "%b") AS x,
	                                (SELECT COUNT(ProjectId) 
		                                FROM 
                                            project
		                                WHERE 
			                                DATE_FORMAT(ProjectDate, "%b") = x
                                            AND 
                                            DATE_FORMAT(ProjectDate, "%Y") = :year:
	                                ) AS y
                                FROM 
	                                project 
                                WHERE
	                                DATE_FORMAT(ProjectDate, "%Y") = :year:;';


    

    




}
