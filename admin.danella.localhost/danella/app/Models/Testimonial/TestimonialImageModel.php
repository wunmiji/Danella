<?php

namespace App\Models\Testimonial;

use CodeIgniter\Model;

class TestimonialImageModel extends Model
{

    protected $table = 'testimonial_image';
    protected $primaryKey = 'TestimonialId';
    protected $allowedFields = [
        'TestimonialId',
        'TestimonialImageFileManagerFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            ti.TestimonialId AS Id,
                            ti.TestimonialImageFileManagerFileFk AS FileId,
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath
                        FROM
                            testimonial_image ti
                            JOIN file_manager_file ff ON ti.TestimonialImageFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            ti.TestimonialId = :testimonialId:;';


}
