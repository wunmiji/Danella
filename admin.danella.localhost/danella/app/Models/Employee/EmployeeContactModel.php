<?php

namespace App\Models\Employee;

use CodeIgniter\Model;

class EmployeeContactModel extends Model {

    protected $table            = 'employee_contact';
    protected $primaryKey       = 'EmployeeId';
    protected $allowedFields    = ['EmployeeId', 'EmployeeContactEmail', 'EmployeeContactMobile', 'EmployeeContactTelephone'];

    // SQL
    protected $sqlContact = 'SELECT
                                EmployeeId,
                                EmployeeContactEmail,
                                EmployeeContactMobile,
                                EmployeeContactTelephone
                            FROM
                                employee_contact 
                            WHERE
                                EmployeeId = :employeeId:;';

                                

}
