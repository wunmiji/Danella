<?php

namespace App\Models\Blog;

use CodeIgniter\Model;

class BlogCategoryModel extends Model
{

    protected $table = 'blog_category';
    protected $primaryKey = 'BlogCategoryId';
    protected $allowedFields = [
        'BlogCategoryId',
        'BlogCategoryBlogFk',
        'BlogCategoryServiceFk'
    ];

    // SQL
    protected $sqlCategory = 'SELECT
                            bc.BlogCategoryId AS Id,
                            bc.BlogCategoryBlogFk AS BlogId,
                            bc.BlogCategoryServiceFk AS ServiceId,
                            s.ServiceName,
                            s.ServiceSlug
                        FROM
                            blog_category bc
                            JOIN service s ON s.ServiceId = bc.BlogCategoryServiceFk 
                        WHERE
                            bc.BlogCategoryBlogFk = :blogId:;';



}
