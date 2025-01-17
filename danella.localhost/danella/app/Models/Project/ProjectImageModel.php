<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class ProjectImageModel extends Model
{

    protected $table = 'project_image';
    protected $primaryKey = 'ProjectId';
    protected $allowedFields = [
        'ProjectId',
        'ProjectImageFileManagerFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            pi.ProjectId AS Id,
                            pi.ProjectImageFileManagerFileFk AS FileId,
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath
                        FROM
                            project_image pi
                            JOIN file_manager_file ff ON pi.ProjectImageFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            pi.ProjectId = :projectId:;';


}
