<?php

namespace App\ImplModel;


use App\Models\Testimonial\TestimonialModel;
use App\Models\Testimonial\TestimonialImageModel;
use App\Entities\Testimonial\TestimonialEntity;
use App\Entities\Testimonial\TestimonialImageEntity;


/**
 * 
 */

class TestimonialImplModel
{


    public function list(int $from, int $to)
    {
        $testimonialModel = new TestimonialModel();
        $query = $testimonialModel->query($testimonialModel->sqlTestimonial, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = $this->testimonial($value);

            array_push($output, $entity);
        }

        return $output;
    }

    public function testimonial($value)
    {

        return new TestimonialEntity(
            $value['TestimonialId'] ?? null,
            $value['TestimonialName'] ?? null,
            $value['TestimonialNote'] ?? null,
            $value['TestimonialPosition'] ?? null,
            
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


    // Other 
    public function count()
    {
        $testimonialModel = new TestimonialModel();
        $query = $testimonialModel->query($testimonialModel->sqlCount);
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

        return $pagination;
    }


}