<?php

namespace App\Models\FileManager;

use CodeIgniter\Model;

class FileManagerFileModel extends Model
{

    protected $table = 'file_manager_file';
    protected $primaryKey = 'FileManagerFileId';
    protected $allowedFields = [
        'FileManagerFileId',
        'FileManagerFileFileManagerFk',
        'FileManagerFileName',
        'FileManagerFileSize',
        'FileManagerFileMimeType',
        'FileManagerFileExtension',
        'FileManagerFileLastModified',
        'CreatedId',
        'CreatedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT FileManagerFileId FROM file_manager_file WHERE FileManagerFileId = :fileManagerFileId:';
    protected $sqlCount = 'SELECT COUNT(*) FROM file_manager_file';
    protected $sqlCountFiles = 'SELECT COUNT(*) FROM file_manager_file WHERE FileManagerFileFileManagerFk = :fileManagerId:';
    protected $sqlSumFileSize = 'SELECT SUM(FileManagerFileSize) FROM file_manager_file WHERE FileManagerFileFileManagerFk = :fileManagerId:';
    protected $sqlSumAllFileSize = 'SELECT SUM(FileManagerFileSize) FROM file_manager_file';
    protected $sqlDelete = 'DELETE FROM file_manager_file WHERE FileManagerFileId = :fileManagerFileId:;';

    protected $sqlFile = 'SELECT
                            ff.FileManagerFileId,
                            ff.FileManagerFileName,
                            ff.FileManagerFileSize,
                            ff.FileManagerFileMimeType,
                            ff.FileManagerFileExtension,
                            ff.FileManagerFileLastModified,
                            f.FileManagerUrlPath,
                            f.FileManagerPath,
                            ce.EmployeeFirstName AS CreatedByFirstName,
                            ce.EmployeeLastName AS CreatedByLastName,
                            ff.CreatedDateTime,
                            ff.CreatedId
                        FROM
                            file_manager_file ff
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId
                            JOIN employee ce ON ff.CreatedId = ce.EmployeeId
                        WHERE
                            ff.FileManagerFileFileManagerFk = :fileManagerId:';
    
    protected $sqlList = 'SELECT
                            ff.FileManagerFileId,
                            ff.FileManagerFileName,
                            ff.FileManagerFileMimeType,
                            f.FileManagerUrlPath
                        FROM
                            file_manager_file ff
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId
                        WHERE
                            ff.FileManagerFileFileManagerFk = :fileManagerId:';

    protected $sqlFilePath = 'SELECT
                            ff.FileManagerFileName,
                            f.FileManagerPath
                        FROM
                            file_manager_file ff
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId
                        WHERE
                            FileManagerFileId = :fileManagerFileId:';

    

}
