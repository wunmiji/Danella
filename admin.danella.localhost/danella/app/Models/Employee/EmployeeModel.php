<?php

namespace App\Models\Employee;

use CodeIgniter\Model;

class EmployeeModel extends Model
{

    protected $table = 'employee';
    protected $primaryKey = 'EmployeeId';
    protected $allowedFields = [
        'EmployeeId',
        'EmployeeFirstName',
        'EmployeeLastName',
        'EmployeeDescription',
        'CreatedDateTime',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT EmployeeId FROM employee ORDER BY EmployeeId DESC LIMIT :from:, :to:';
    protected $sqlCount = 'SELECT COUNT(*) FROM employee';
    protected $sqlDelete = 'DELETE FROM employee WHERE EmployeeId = :employeeId:;';
    protected $sqlEmployee = 'SELECT
                                EmployeeId,
                                EmployeeFirstName,
                                EmployeeLastName,
                                EmployeeDescription,
                                CreatedDateTime,
                                ModifiedDateTime
                            FROM
                                employee 
                            WHERE
                                EmployeeId = :employeeId:;';
    protected $sqlEmail = 'SELECT e.EmployeeId FROM employee e JOIN employee_contact ec ON e.EmployeeId = ec.EmployeeId WHERE EmployeeContactEmail = :employeeContactEmail:';

}
