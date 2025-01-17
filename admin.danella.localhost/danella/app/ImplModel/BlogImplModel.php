<?php

namespace App\ImplModel;


use App\Models\Blog\BlogModel;
use App\Models\Blog\BlogImageModel;
use App\Models\Blog\BlogTextModel;
use App\Models\Blog\BlogAuthorModel;
use App\Models\Blog\BlogCategoryModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
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
        $query = $blogModel->query($blogModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = new BlogEntity(
                $value['BlogId'] ?? null,
                $value['BlogTitle'] ?? null,
                null,
                $value['BlogSummary'] ?? null,
                $value['BlogStatus'] ?? null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function blogPerMonth(int $year)
    {
        $blogModel = new BlogModel();
        $query = $blogModel->query($blogModel->blogPerMonth, [
            'year' => $year
        ]);
        $list = $query->getResultArray();

        $default = [
            ['x' => 'Jan', 'y' => '0'],
            ['x' => 'Feb', 'y' => '0'],
            ['x' => 'Mar', 'y' => '0'],
            ['x' => 'Apr', 'y' => '0'],
            ['x' => 'May', 'y' => '0'],
            ['x' => 'Jun', 'y' => '0'],
            ['x' => 'Jul', 'y' => '0'],
            ['x' => 'Aug', 'y' => '0'],
            ['x' => 'Sep', 'y' => '0'],
            ['x' => 'Oct', 'y' => '0'],
            ['x' => 'Nov', 'y' => '0'],
            ['x' => 'Dec', 'y' => '0']
        ];

        foreach ($default as $defaultKey => $value) {
            foreach ($list as $key => $each) {
                if ($value['x'] == $each['x']) {
                    $default[$defaultKey] = $each;
                }
            }
        }

        $list = array_column($default, 'y');
        
        return json_encode($list);
    }

    public function retrieve(int $num)
    {
        $blogModel = new BlogModel();
        $query = $blogModel->query($blogModel->sqlRetrieve, [
            'blogId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->blog($row);
        }
    }

    public function blog($value)
    {
        return new BlogEntity(
            $value['BlogId'] ?? null,
            $value['BlogTitle'] ?? null,
            $value['BlogSlug'] ?? null,
            $value['BlogSummary'] ?? null,
            $value['BlogStatus'] ?? null,
            DateLibrary::getFormat($value['BlogPublishedDate'] ?? null),

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

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
                $row['ServiceName'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function save($data, $dataImage, $dataText, $dataAuthor, $dataCategories)
    {
        try {
            $blogModel = new BlogModel();

            $blogModel->transException(true)->transStart();

            // Insert into blog
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $blogId = $blogModel->insert($data);

            // Insert into blog_image
            $dataImage['BlogId'] = $blogId;
            $blogImageModel = new BlogImageModel();
            $blogImageModel->insert($dataImage);

            // Insert into blog_text
            $dataText['BlogId'] = $blogId;
            $blogTextModel = new BlogTextModel();
            $blogTextModel->insert($dataText);

            // Insert into blog_author
            $dataAuthor['BlogId'] = $blogId;
            $blogAuthorModel = new BlogAuthorModel();
            $blogAuthorModel->insert($dataAuthor);

            // Insert into blog_service
            $blogCategoryModel = new BlogCategoryModel();
            foreach ($dataCategories as $service) {
                $service['BlogCategoryBlogFk'] = $blogId;
                $blogCategoryModel->insert($service);
            }

            $blogModel->transComplete();

            if ($blogModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function update($num, $data, $dataImage, $dataText, $dataAuthor, $dataCategories)
    {
        try {
            $blogModel = new BlogModel();

            $blogModel->transException(true)->transStart();

            // Update into blog
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $blogModel->update($num, $data);

            // Update into blog_text
            $blogTextModel = new BlogTextModel();
            $blogTextModel->update($num, $dataText);

            // Update into blog_image
            $blogImageModel = new BlogImageModel();
            $blogImageModel->update($num, $dataImage);

            // Update into blog_author
            $blogAuthorModel = new BlogAuthorModel();
            $blogAuthorModel->update($num, $dataAuthor);

            // Update into blog_service
            $blogServiceModel = new BlogCategoryModel();
            $beforeAll = $blogServiceModel->where('BlogCategoryBlogFk', $num)->findAll();
            $beforeAllColumn = array_column($beforeAll, 'BlogCategoryId');
            $dataCategoriesColumn = array_column($dataCategories, 'BlogCategoryId');
            $diffArray = ArrayLibrary::getOneToMany($beforeAllColumn, $dataCategoriesColumn);
            foreach ($diffArray as $diff) {
                $blogServiceModel->delete(intval($diff));
            }
            foreach ($dataCategories as $each) {
                $blogServiceModel->save($each);
            }


            $blogModel->transComplete();

            if ($blogModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            return $e->getCode();
        }
    }

    public function delete(int $num)
    {
        try {
            $blogModel = new BlogModel();
            $blogModel->transException(true)->transStart();

            $query = $blogModel->query($blogModel->sqlDelete, [
                'blogId' => $num,
            ]);

            $affected_rows = $blogModel->affectedRows();

            $blogModel->transComplete();
            if ($affected_rows >= 1 && $blogModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function status(int $num, int $employeeId)
    {
        try {
            $blogModel = new BlogModel();

            $blogModel->transException(true)->transStart();
            $dateTime = DateLibrary::getZoneDateTime();

            $query = $blogModel->query($blogModel->sqlStatus, [
                'blogId' => $num,
            ]);
            $row = $query->getRowArray();
            if (is_null($row))
                return false;


            $data['BlogPublishedDate'] = $dateTime;
            $data['BlogStatus'] = (boolval($row['BlogStatus']) === true) ? false : true;
            $data['ModifiedId'] = $employeeId;
            $data['ModifiedDateTime'] = $dateTime;
            $blogModel->update($num, $data);

            $blogModel->transComplete();
            if ($blogModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
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

    public function pagination(int $queryPage, int $queryLimit)
    {
        $pagination = array();
        $totalCount = $this->count();
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->list($next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);
        
        $pagination['list'] = $list;
        $pagination['queryLimit'] = $queryLimit;
        $pagination['queryPage'] = $queryPage;
        $pagination['arrayPageCount'] = $arrayPageCount;

        return $pagination;
    }


}