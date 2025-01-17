<?php

namespace App\ImplModel;


use App\Models\Blog\BlogModel;
use App\Models\Blog\BlogImageModel;
use App\Models\Blog\BlogTextModel;
use App\Models\Blog\BlogAuthorModel;
use App\Models\Blog\BlogCategoryModel;
use App\Libraries\DateLibrary;
use App\Entities\Blog\BlogEntity;
use App\Entities\Blog\BlogImageEntity;
use App\Entities\Blog\BlogTextEntity;
use App\Entities\Blog\BlogAuthorEntity;
use App\Entities\Blog\BlogCategoryEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class BlogImplModel
{


    public function list(int $from, int $to)
    {
        $blogModel = new BlogModel();
        $query = $blogModel->query($blogModel->sqlList, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = new BlogEntity(
                $value['BlogId'] ?? null,
                $value['BlogTitle'] ?? null,
                $value['BlogSlug'] ?? null,
                $value['BlogSummary'] ?? null,
                $value['BlogStatus'] ?? null,
                DateLibrary::getDate($value['BlogPublishedDate'] ?? null),

                $this->blogImage($value['BlogId']),
                null,
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function related(array $blogCategoriesId)
    {
        $relatedBlogs = array();
        foreach ($blogCategoriesId as $categoryId) {
            $blogModel = new BlogModel();
            $query = $blogModel->query($blogModel->sqlRelated, [
                'blogCategoryServiceFk' => $categoryId
            ]);
            $list = $query->getResultArray();

            $output = array();
            foreach ($list as $key => $value) {
                $entity = new BlogEntity(
                    $value['BlogId'] ?? null,
                    $value['BlogTitle'] ?? null,
                    $value['BlogSlug'] ?? null,
                    null,
                    null,
                    DateLibrary::getDatedFY($value['BlogPublishedDate'] ?? null),

                    $this->blogImage($value['BlogId']),
                    null,
                    null,
                    null
                );
                array_push($output, $entity);
            }
            
            // Merge into single array of objects
            $relatedBlogs = array_merge($relatedBlogs, $output);
        }

        // Remove duplicates
        $relatedBlogs = array_intersect_key($relatedBlogs, array_unique(array_column($relatedBlogs, 'id')));

        // Sort array based
        usort($relatedBlogs, function ($a, $b) {
            return strtotime($a->publishedDate) < strtotime($b->publishedDate);
        });

        return $relatedBlogs;
    }

    public function retrieve(string $slug)
    {
        $blogModel = new BlogModel();
        $query = $blogModel->query($blogModel->sqlRetrieve, [
            'slug' => $slug,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else
            return $this->blog($row);

    }

    public function blog($value)
    {
        return new BlogEntity(
            $value['BlogId'] ?? null,
            $value['BlogTitle'] ?? null,
            $value['BlogSlug'] ?? null,
            $value['BlogSummary'] ?? null,
            $value['BlogStatus'] ?? null,
            DateLibrary::getDate($value['BlogPublishedDate'] ?? null),

            $this->blogImage($value['BlogId']),
            $this->blogText($value['BlogId']),
            $this->blogAuthor($value['BlogId']),
            $this->blogCategory($value['BlogId'])

        );

    }

    public function blogImage(int $num)
    {
        $blogImageModel = new BlogImageModel();
        $query = $blogImageModel->query($blogImageModel->sqlFile, [
            'blogId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new BlogImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $arr['FileManagerFileName'],
            $arr['FileManagerFileName'] ?? null,
        );

        return $entity;
    }

    public function blogText(int $num)
    {
        $blogTextModel = new BlogTextModel();
        $query = $blogTextModel->query($blogTextModel->sqlText, [
            'blogId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new BlogTextEntity(
            $num,
            $arr['BlogText'] ?? null
        );

        return $entity;
    }

    public function blogAuthor(int $num)
    {
        $blogAuthorModel = new BlogAuthorModel();
        $query = $blogAuthorModel->query($blogAuthorModel->sqlAuthor, [
            'blogId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new BlogAuthorEntity(
            $num,
            $arr['BlogAuthorEmployeeFk'] ?? null,
            $arr['FirstName'] . ' ' . $arr['LastName'] ?? null,
            $arr['EmployeeDescription'] ?? null,
            $arr['FileId'] ?? null,
            $arr['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $arr['FileManagerFileName'],
            $arr['FileManagerFileName'] ?? null,
        );

        return $entity;
    }

    public function blogCategory(int $num)
    {
        $blogCategoryModel = new BlogCategoryModel();
        $query = $blogCategoryModel->query($blogCategoryModel->sqlCategory, [
            'blogId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new BlogCategoryEntity(
                $row['Id'],
                $row['BlogId'] ?? null,
                $row['ServiceId'] ?? null,
                $row['ServiceName'] ?? null,
                $row['ServiceSlug'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function slug(string $slug)
    {
        $blogModel = new BlogModel();
        $query = $blogModel->query($blogModel->sqlSlug, [
            'slug' => $slug,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->blog($row);
        }
    }



    // Other 
    public function count()
    {
        $blogModel = new BlogModel();
        $query = $blogModel->query($blogModel->sqlCount);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function pagination(int $queryCount)
    {
        $pagination = array();
        $totalCount = $this->count();
        $list = array();
        $listNumber = 1;
        $pageCount = ceil($totalCount / $listNumber);
        $arrayPageCount = array();

        $next = ($queryCount * $listNumber) - $listNumber;
        $list = $this->list($next, $listNumber);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['arrayPageCount'] = $arrayPageCount;
        $pagination['next'] = $next;

        return $pagination;
    }


}