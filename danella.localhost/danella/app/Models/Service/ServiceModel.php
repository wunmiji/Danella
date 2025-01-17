<?php

namespace App\Models\Service;

use CodeIgniter\Model;

class ServiceModel extends Model
{

    protected $table = 'service';
    protected $primaryKey = 'ServiceId';
    protected $allowedFields = [
        'ServiceId',
        'ServiceName',
        'ServiceSlug',
        'ServiceDescription',
        'ServiceStatus',
    ];

    // SQL
    protected $sqlSlug = 'SELECT
                            ServiceId,
                            ServiceName,
                            ServiceSlug,
                            ServiceDescription,
                            ServiceStatus
                        FROM 
                            service 
                        WHERE 
                            ServiceSlug = :slug: 
                            AND 
                            ServiceStatus = true;';
    
    protected $sqlList = 'SELECT
                            ServiceId,
                            ServiceName,
                            ServiceSlug,
                            ServiceDescription
                        FROM 
                            service 
                        WHERE
                            ServiceStatus = true 
                        ORDER BY 
                            ServiceName 
                        ASC';

    protected $sqlListName = 'SELECT
                            ServiceName,
                            ServiceSlug
                        FROM 
                            service 
                        WHERE
                            ServiceStatus = true 
                        ORDER BY 
                            ServiceName 
                        ASC';




}
