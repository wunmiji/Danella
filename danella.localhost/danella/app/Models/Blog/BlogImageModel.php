<?php

namespace App\Models\Blog;

use CodeIgniter\Model;

class BlogImageModel extends Model
{

    protected $table = 'blog_image';
    protected $primaryKey = 'BlogId';
    protected $allowedFields = [
        'BlogId',
        'BlogImageFileManagerFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            bi.BlogId AS Id,
                            bi.BlogImageFileManagerFileFk AS FileId,
                            ff.FileManagerFileName,
                            f.FileManagerUrlPath
                        FROM
                            blog_image bi
                            JOIN file_manager_file ff ON bi.BlogImageFileManagerFileFk = ff.FileManagerFileId 
                            JOIN file_manager f ON ff.FileManagerFileFileManagerFk = f.FileManagerId 
                        WHERE
                            bi.BlogId = :blogId:;';


}
