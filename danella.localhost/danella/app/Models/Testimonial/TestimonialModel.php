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
        'TestimonialNote',
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(TestimonialId) AS COUNT FROM testimonial WHERE TestimonialStatus = true ';
    protected $sqlTestimonial = 'SELECT
                            TestimonialId,
                            TestimonialName,
                            TestimonialNote,
                            TestimonialPosition
                        FROM
                            testimonial 
                        WHERE 
                            TestimonialStatus = true 
                        ORDER BY 
                            TestimonialId 
                        DESC 
                        LIMIT 
                            :from:, :to:';



}
