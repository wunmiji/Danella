<?php

namespace App\ImplModel;


use App\Models\Testimonial\TestimonialModel;
use App\Models\Testimonial\TestimonialImageModel;
use App\Libraries\DateLibrary;
use App\Entities\Testimonial\TestimonialEntity;
use App\Entities\Testimonial\TestimonialImageEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class TestimonialImplModel
{


    public function list(int $from, int $to)
    {
        $testimonialModel = new TestimonialModel();
        $query = $testimonialModel->query($testimonialModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TestimonialEntity(
                $value['TestimonialId'] ?? null,
                $value['TestimonialName'] ?? null,
                $value['TestimonialStatus'] ?? null,
                null,
                $value['TestimonialPosition'] ?? null,
    
                null,
                null,
                null,
    
                null,
                null,
                null,
    
                null,
            );;
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(int $num)
    {
        $testimonialModel = new TestimonialModel();
        $query = $testimonialModel->query($testimonialModel->sqlRetrieve, [
            'testimonialId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->testimonial($row);
        }
    }

    public function testimonial($value)
    {

        return new TestimonialEntity(
            $value['TestimonialId'] ?? null,
            $value['TestimonialName'] ?? null,
            $value['TestimonialStatus'] ?? null,
            $value['TestimonialNote'] ?? null,
            $value['TestimonialPosition'] ?? null,

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->testimonialImage($value['TestimonialId']) ?? null,
        );


    }

    public function testimonialImage(int $num)
    {
        $testimonialImageModel = new TestimonialImageModel();
        $query = $testimonialImageModel->query($testimonialImageModel->sqlFile, [
            'testimonialId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new TestimonialImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $arr['FileManagerFileName'],
            $arr['FileManagerFileName'] ?? null,
        );

        return $entity;
    }

    public function save($data, $dataImage)
    {
        try {
            $testimonialModel = new TestimonialModel();

            $testimonialModel->transException(true)->transStart();

            // Insert into testimonial
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            ;
            $testimonialId = $testimonialModel->insert($data);

            // Insert into testimonial_image
            $dataImage['TestimonialId'] = $testimonialId;
            $testimonialImageModel = new TestimonialImageModel();
            $testimonialImageModel->insert($dataImage);

            $testimonialModel->transComplete();

            if ($testimonialModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
            \Sentry\captureException($e);
        }
    }

    public function update($num, $data, $dataImage)
    {
        try {
            $testimonialModel = new TestimonialModel();

            $testimonialModel->transException(true)->transStart();

            // Update into testimonial
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $testimonialModel->update($num, $data);

            // Update into testimonial_image
            $testimonialImageModel = new TestimonialImageModel();
            $testimonialImageModel->update($num, $dataImage);

            $testimonialModel->transComplete();

            if ($testimonialModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function delete(int $num)
    {
        try {
            $testimonialModel = new TestimonialModel();
            $testimonialModel->transException(true)->transStart();

            $query = $testimonialModel->query($testimonialModel->sqlDelete, [
                'testimonialId' => $num,
            ]);

            $affected_rows = $testimonialModel->affectedRows();

            $testimonialModel->transComplete();
            if ($affected_rows >= 1 && $testimonialModel->transStatus() === true)
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
            $testimonialModel = new TestimonialModel();
            $testimonialModel->transException(true)->transStart();

            $query = $testimonialModel->query($testimonialModel->sqlStatus, [
                'testimonialId' => $num,
            ]);
            $row = $query->getRowArray();
            if (is_null($row))
                return false;

            
            $data['TestimonialStatus'] = (boolval($row['TestimonialStatus']) === true) ? false : true; 
            $data['ModifiedId'] = $employeeId;
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $testimonialModel->update($num, $data);

            $testimonialModel->transComplete();
            if ($testimonialModel->transStatus() === true)
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
        $testimonialModel = new TestimonialModel();
        $query = $testimonialModel->query($testimonialModel->sqlCount);
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