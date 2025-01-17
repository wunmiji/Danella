<?php

namespace App\Models\Service;

use CodeIgniter\Model;

class ServiceFaqModel extends Model
{

    protected $table = 'service_faq';
    protected $primaryKey = 'ServiceFaqId';
    protected $allowedFields = ['ServiceFaqId', 'ServiceFaqServiceFk', 'ServiceFaqQuestion', 'ServiceFaqAnswer'];

    
    protected $sqlServiceFaq = 'SELECT
                            ServiceFaqId,
                            ServiceFaqServiceFk AS ServiceId,
                            ServiceFaqQuestion,
                            ServiceFaqAnswer
                        FROM
                            service_faq 
                        WHERE
                            ServiceFaqServiceFk = :serviceId:;';



}
