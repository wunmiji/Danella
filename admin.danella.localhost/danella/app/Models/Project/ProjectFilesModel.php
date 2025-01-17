<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class ProjectFilesModel extends Model
{

    protected $table = 'project_files';
    protected $primaryKey = 'ProjectFilesId';
    protected $allowedFields = [
        'ProjectFilesId',
        'ProjectFilesProjectFk',
        'ProjectFilesFileManagerFileFk',
    ];

    // SQL
    protected $sqlFiles = 'SELECT
                            pf.ProjectFilesId,
                            pf.ProjectFilesProjectFk AS ProjectId,
                            pf.ProjectFilesFileManagerFileFk  AS FileId, 
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath,
                            ff.FileManagerFileMimeType,
                            f.FileManagerId,
                            f.FileManagerName
                        FROM
                            project_files pf
                            JOIN file_manager_file ff ON pf.ProjectFilesFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            pf.ProjectFilesProjectFk = :projectId:;';



}
