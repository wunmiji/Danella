<?php

namespace App\Models\Employee;

use CodeIgniter\Model;

class EmployeeSecretModel extends Model {

    protected $table            = 'employee_secret';
    protected $primaryKey       = 'EmployeeId';
    protected $allowedFields    = ['EmployeeId', 'EmployeeSecretPassword', 'EmployeeSecretSalt'];

    // SQL
    protected $sqlSecret = 'SELECT
                                EmployeeId,
                                EmployeeSecretPassword,
                                EmployeeSecretSalt
                            FROM
                                employee_secret 
                            WHERE
                                EmployeeId = :employeeId:;';




}
