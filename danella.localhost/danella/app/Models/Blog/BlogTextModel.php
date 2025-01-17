<?php

namespace App\Models\Blog;

use CodeIgniter\Model;

class BlogTextModel extends Model
{

    protected $table = 'blog_text';
    protected $primaryKey = 'BlogId';
    protected $allowedFields = [
        'BlogId',
        'BlogText',
    ];

    // SQL
    protected $sqlText = 'SELECT
                            BlogId,
                            BlogText
                        FROM
                            blog_text 
                        WHERE
                            BlogId = :blogId:;';

}
