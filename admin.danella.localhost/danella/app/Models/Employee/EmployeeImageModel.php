<?php

namespace App\Models\Employee;

use CodeIgniter\Model;

class EmployeeImageModel extends Model
{

    protected $table = 'employee_image';
    protected $primaryKey = 'EmployeeId';
    protected $allowedFields = [
        'EmployeeId',
        'EmployeeImageFileManagerFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            ei.EmployeeId AS Id,
                            ei.EmployeeImageFileManagerFileFk AS FileId,
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath
                        FROM
                            employee_image ei
                            JOIN file_manager_file ff ON ei.EmployeeImageFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            ei.EmployeeId = :employeeId:;';


}
