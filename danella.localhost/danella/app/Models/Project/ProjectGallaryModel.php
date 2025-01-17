<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class ProjectGallaryModel extends Model
{

    protected $table = 'project_gallary';
    protected $primaryKey = 'ProjectGallaryId';
    protected $allowedFields = [
        'ProjectGallaryId',
        'ProjectGallaryProjectFk',
        'ProjectGallaryFileManagerFileFk',
    ];

    // SQL
    protected $sqlGallary = 'SELECT
                            pg.ProjectGallaryId,
                            pg.ProjectGallaryProjectFk AS ProjectId,
                            pg.ProjectGallaryFileManagerFileFk  AS FileId, 
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath,
                            ff.FileManagerFileMimeType
                        FROM
                            project_gallary pg
                            JOIN file_manager_file ff ON pg.ProjectGallaryFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            pg.ProjectGallaryProjectFk = :projectId:;';



}
