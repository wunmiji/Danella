<?php

namespace App\Models\Service;

use CodeIgniter\Model;

class ServiceTextModel extends Model
{

    protected $table = 'service_text';
    protected $primaryKey = 'ServiceId';
    protected $allowedFields = [
        'ServiceId',
        'ServiceText',
    ];

    // SQL
    protected $sqlText = 'SELECT
                            ServiceId,
                            ServiceText
                        FROM
                            service_text 
                        WHERE
                            ServiceId = :serviceId:;';

}
