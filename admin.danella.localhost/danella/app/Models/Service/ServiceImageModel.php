<?php

namespace App\Models\Service;

use CodeIgniter\Model;

class ServiceImageModel extends Model
{

    protected $table = 'service_image';
    protected $primaryKey = 'ServiceId';
    protected $allowedFields = [
        'ServiceId',
        'ServiceImageFileManagerFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            si.ServiceId AS Id,
                            si.ServiceImageFileManagerFileFk AS FileId,
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath
                        FROM
                            service_image si
                            JOIN file_manager_file ff ON si.ServiceImageFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            si.ServiceId = :serviceId:;';


}
