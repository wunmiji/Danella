<?php

namespace App\Models\Blog;

use CodeIgniter\Model;

class BlogModel extends Model
{

    protected $table = 'blog';
    protected $primaryKey = 'BlogId';
    protected $allowedFields = [
        'BlogId',
        'BlogTitle',
        'BlogSlug',
        'BlogSummary',
        'BlogPublishedDate',
        'BlogStatus'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(BlogId) AS COUNT FROM blog WHERE BlogStatus = true;';
    protected $sqlList = 'SELECT
                            BlogId,
                            BlogTitle,
                            BlogSlug,
                            BlogSummary,
                            BlogPublishedDate
                        FROM
                            blog 
                        WHERE 
                            BlogStatus = true
                        ORDER BY 
                            BlogPublishedDate 
                        DESC 
                        LIMIT 
                            :from:, :to:;';


    protected $sqlRelated = 'SELECT 
                                b.BlogId,
                                b.BlogTitle,
                                b.BlogSlug,
                                b.BlogPublishedDate
                            FROM 
                                blog b  
                                JOIN blog_category bc ON b.BlogId = bc.BlogCategoryBlogFk 
                            WHERE 
                                b.BlogStatus = true
                                AND
                                bc.BlogCategoryServiceFk = :blogCategoryServiceFk:
                            ORDER BY 
                                b.BlogPublishedDate DESC 
                            LIMIT 3';
    protected $sqlRetrieve = 'SELECT
                            BlogId,
                            BlogTitle,
                            BlogSlug,
                            BlogSummary,
                            BlogStatus,
                            BlogPublishedDate
                        FROM
                            blog 
                        WHERE
                            BlogStatus = true
                            AND
                            BlogSlug = :slug:;';



}
