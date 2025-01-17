<?php

namespace App\Models\Blog;

use CodeIgniter\Model;

class BlogAuthorModel extends Model
{

    protected $table = 'blog_author';
    protected $primaryKey = 'BlogId';
    protected $allowedFields = [
        'BlogId',
        'BlogAuthorEmployeeFk',
    ];

    // SQL
    protected $sqlAuthor = 'SELECT
                            ba.BlogId,
                            ba.BlogAuthorEmployeeFk,
                            e.EmployeeFirstName AS FirstName,
                            e.EmployeeLastName AS LastName,
                            e.EmployeeDescription,
                            ei.EmployeeImageFileManagerFileFk AS FileId,
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath
                        FROM
                            blog_author ba
                            JOIN employee e ON ba.BlogAuthorEmployeeFk = e.EmployeeId
                            JOIN employee_image ei ON ba.BlogAuthorEmployeeFk = ei.EmployeeId
                            JOIN file_manager_file ff ON ei.EmployeeImageFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId
                            
                        WHERE
                            ba.BlogId = :blogId:;';

}
