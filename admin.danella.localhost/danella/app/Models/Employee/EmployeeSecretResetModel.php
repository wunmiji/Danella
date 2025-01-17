<?php

namespace App\Models\Employee;

use CodeIgniter\Model;

class EmployeeSecretResetModel extends Model
{

    protected $table = 'employee_secret_reset';
    protected $primaryKey = 'EmployeeId';
    protected $allowedFields = [
        'EmployeeId',
        'EmployeeSecretResetToken',
        'EmployeeSecretExpiresAt'
    ];

    // SQL
    protected $sqlSecretReset = 'SELECT
                                EmployeeId,
                                EmployeeSecretResetToken,
                                EmployeeSecretExpiresAt
                            FROM
                                employee_secret_reset 
                            WHERE
                                EmployeeId = :employeeId:;';

    protected $sqlToken = 'SELECT 
                                EmployeeId, 
                                EmployeeSecretExpiresAt
                            FROM 
                                employee_secret_reset 
                            WHERE 
                                EmployeeSecretResetToken = :employeeSecretResetToken:';




}
