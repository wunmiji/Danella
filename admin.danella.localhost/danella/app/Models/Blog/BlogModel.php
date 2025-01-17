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
        'BlogStatus',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT BlogId FROM blog ORDER BY BlogId DESC LIMIT :from:, :to:';
    protected $sqlCount = 'SELECT COUNT(BlogId) AS COUNT FROM blog';
    protected $sqlSlug = 'SELECT BlogSlug FROM blog WHERE BlogSlug = :slug:';
    protected $sqlDelete = 'DELETE FROM blog WHERE BlogId = :blogId:;';
    protected $sqlStatus = 'SELECT BlogStatus FROM blog WHERE BlogId = :blogId:;';
    protected $sqlTable = 'SELECT
                            BlogId,
                            BlogTitle,
                            BlogStatus,
                            BlogSummary
                        FROM
                            blog 
                        ORDER BY 
                            BlogId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';
    protected $sqlRetrieve = 'SELECT
                            b.BlogId,
                            b.BlogTitle,
                            b.BlogSlug,
                            b.BlogSummary,
                            b.BlogStatus,
                            b.BlogPublishedDate,
                            ce.EmployeeFirstName AS CreatedByFirstName,
                            ce.EmployeeLastName AS CreatedByLastName,
                            b.CreatedDateTime,
                            b.CreatedId,
                            me.EmployeeFirstName AS ModifiedByFirstName,
                            me.EmployeeLastName AS ModifiedByLastName,
                            b.ModifiedDateTime,
                            b.ModifiedId
                        FROM
                            blog b
                            JOIN employee ce ON b.CreatedId = ce.EmployeeId
                            LEFT JOIN employee me ON b.ModifiedId = me.EmployeeId
                        WHERE
                            b.BlogId = :blogId:;';

    protected $blogPerMonth = 'SELECT 
	                                DISTINCT DATE_FORMAT(BlogPublishedDate, "%b") AS x,
	                                (SELECT COUNT(BlogId) 
		                                FROM 
                                            blog
		                                WHERE 
			                                DATE_FORMAT(BlogPublishedDate, "%b") = x
                                            AND 
                                            DATE_FORMAT(BlogPublishedDate, "%Y") = :year:
	                                ) AS y
                                FROM 
	                                blog 
                                WHERE
	                                DATE_FORMAT(BlogPublishedDate, "%Y") = :year:;';

}
