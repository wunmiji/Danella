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
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT ServiceId FROM service ORDER BY ServiceId DESC LIMIT :from:, :to:';
    protected $sqlCount = 'SELECT COUNT(ServiceId) AS COUNT FROM service';
    protected $sqlSlug = 'SELECT ServiceSlug FROM service WHERE ServiceSlug = :slug:';
    protected $sqlDelete = 'DELETE FROM service WHERE ServiceId = :serviceId:;';
    protected $sqlStatus = 'SELECT ServiceStatus FROM service WHERE ServiceId = :serviceId:;';
    protected $sqlServiceName = 'SELECT ServiceId AS id, ServiceName AS name FROM service WHERE ServiceStatus = true ORDER BY ServiceName ASC;';
    protected $sqlTable = 'SELECT
                            ServiceId,
                            ServiceName,
                            ServiceStatus
                        FROM
                            service 
                        ORDER BY 
                            ServiceId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';
    protected $sqlService = 'SELECT
                            s.ServiceId,
                            s.ServiceName,
                            s.ServiceSlug,
                            s.ServiceDescription,
                            s.ServiceStatus,
                            ce.EmployeeFirstName AS CreatedByFirstName,
                            ce.EmployeeLastName AS CreatedByLastName,
                            s.CreatedDateTime,
                            s.CreatedId,
                            me.EmployeeFirstName AS ModifiedByFirstName,
                            me.EmployeeLastName AS ModifiedByLastName,
                            s.ModifiedDateTime,
                            s.ModifiedId
                        FROM
                            service s
                            JOIN employee ce ON s.CreatedId = ce.EmployeeId
                            LEFT JOIN employee me ON s.ModifiedId = me.EmployeeId
                        WHERE
                            s.ServiceId = :serviceId:;';

protected $sqlServiceNameChart = 'SELECT ServiceName AS name FROM service ORDER BY ServiceName ASC;';

    protected $sqlServicePerProject = 'SELECT 
                                            ServiceName AS y,
                                            (SELECT COUNT(ProjectServiceServiceFk) 
									            FROM project_service 
                                                WHERE ProjectServiceServiceFk = ServiceId) AS x
                                        FROM 
                                            service;'; 

    protected $sqlServicePerBlog = 'SELECT 
                                            ServiceName AS y,
                                            (SELECT COUNT(BlogCategoryServiceFk) 
									            FROM blog_category 
                                                WHERE BlogCategoryServiceFk = ServiceId) AS x
                                        FROM 
                                            service;';
                                
    protected $sqlServicePerProjectStaus = 'SELECT 
                                            ServiceName AS y,
                                            (SELECT COUNT(ProjectServiceServiceFk) 
									            FROM danella.project_service 
                                                WHERE ProjectServiceServiceFk = ServiceId) AS x
                                        FROM 
                                            service
                                        WHERE
                                            ServiceStatus = :status:;';



}
