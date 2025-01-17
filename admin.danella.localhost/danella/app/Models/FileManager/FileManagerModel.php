<?php

namespace App\Models\FileManager;

use CodeIgniter\Model;

class FileManagerModel extends Model
{

    protected $table = 'file_manager';
    protected $primaryKey = 'FileManagerId';
    protected $allowedFields = [
        'FileManagerId',
        'FileManagerName',
        'FileManagerType',
        'FileManagerUrlPath',
        'FileManagerDescription',
        'FileManagerPath',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(FileManagerId) AS COUNT FROM file_manager';
    protected $sqlFolderPath = 'SELECT FileManagerPath FROM file_manager WHERE FileManagerId = :fileManagerId:';
    protected $sqlDelete = 'DELETE FROM file_manager WHERE FileManagerId = :fileManagerId:;';
    protected $sqlTable = 'SELECT
                            FileManagerId,
                            FileManagerName,
                            FileManagerType
                        FROM
                            file_manager 
                        ORDER BY 
                            FileManagerId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';
                            
    protected $sqlList = 'SELECT
                            FileManagerId,
                            FileManagerName,
                            FileManagerPath
                        FROM
                            file_manager 
                        WHERE 
                            FileManagerType = :type:
                        ORDER BY 
                            FileManagerName;';
    
    protected $sqlRetrieve = 'SELECT
                            f.FileManagerId,
                            f.FileManagerName,
                            f.FileManagerType,
                            f.FileManagerUrlPath,
                            f.FileManagerDescription,
                            f.FileManagerPath,
                            ce.EmployeeFirstName AS CreatedByFirstName,
                            ce.EmployeeLastName AS CreatedByLastName,
                            f.CreatedDateTime,
                            f.CreatedId,
                            me.EmployeeFirstName AS ModifiedByFirstName,
                            me.EmployeeLastName AS ModifiedByLastName,
                            f.ModifiedDateTime,
                            f.ModifiedId
                        FROM
                            file_manager f
                            JOIN employee ce ON f.CreatedId = ce.EmployeeId
                            LEFT JOIN employee me ON f.ModifiedId = me.EmployeeId
                        WHERE
                            f.FileManagerId = :fileManagerId:;';

    protected $sqlSimpleRetrieve = 'SELECT
                            FileManagerId,
                            FileManagerName,
                            FileManagerType
                        FROM
                            file_manager 
                        WHERE
                            FileManagerId = :fileManagerId:;';

}
