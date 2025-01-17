<?php

namespace App\Models\Testimonial;

use CodeIgniter\Model;

class TestimonialModel extends Model
{

    protected $table = 'testimonial';
    protected $primaryKey = 'TestimonialId';
    protected $allowedFields = [
        'TestimonialId',
        'TestimonialName',
        'TestimonialPosition',
        'TestimonialStatus',
        'TestimonialNote',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(TestimonialId) AS COUNT FROM testimonial';
    protected $sqlStatus = 'SELECT TestimonialStatus FROM testimonial WHERE TestimonialId = :testimonialId:;';
    protected $sqlDelete = 'DELETE FROM testimonial WHERE TestimonialId = :testimonialId:;';
    protected $sqlTable = 'SELECT
                            TestimonialId,
                            TestimonialName,
                            TestimonialPosition,
                            TestimonialStatus
                        FROM
                            testimonial 
                        ORDER BY 
                            TestimonialId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';
    
    protected $sqlRetrieve = 'SELECT
                            t.TestimonialId,
                            t.TestimonialName,
                            t.TestimonialNote,
                            t.TestimonialPosition,
                            t.TestimonialStatus,
                            ce.EmployeeFirstName AS CreatedByFirstName,
                            ce.EmployeeLastName AS CreatedByLastName,
                            t.CreatedDateTime,
                            t.CreatedId,
                            me.EmployeeFirstName AS ModifiedByFirstName,
                            me.EmployeeLastName AS ModifiedByLastName,
                            t.ModifiedDateTime,
                            t.ModifiedId
                        FROM
                            testimonial t
                            JOIN employee ce ON t.CreatedId = ce.EmployeeId
                            LEFT JOIN employee me ON t.ModifiedId = me.EmployeeId
                        WHERE
                            t.TestimonialId = :testimonialId:;';



}
