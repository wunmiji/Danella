<?php

namespace App\ImplModel;


use App\Models\Service\ServiceModel;
use App\Models\Service\ServiceImageModel;
use App\Models\Service\ServiceTextModel;
use App\Models\Service\ServiceFaqModel;
use App\Entities\Service\ServiceEntity;
use App\Entities\Service\ServiceImageEntity;
use App\Entities\Service\ServiceTextEntity;
use App\Entities\Service\ServiceFaqEntity;


/**
 * 
 */

class ServiceImplModel
{

    public function list()
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlList);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ServiceEntity(
                $value['ServiceId'] ?? null,
                $value['ServiceName'] ?? null,
                $value['ServiceSlug'] ?? null,
                $value['ServiceDescription'] ?? null,

                isset($value['ServiceId']) ? $this->serviceImage($value['ServiceId']) : null,
                null,
                null,
            );

            array_push($output, $entity);
        }

        return $output;
    }

    public function listName()
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlListName);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ServiceEntity(
                null,
                $value['ServiceName'] ?? null,
                $value['ServiceSlug'] ?? null,
                null,

                null,
                null,
                null,
            );;

            array_push($output, $entity);
        }

        return $output;
    }

    public function slug(string $link)
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlSlug, [
            'slug' => $link,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->service($row);
        }


    }

    public function service($value)
    {
        return new ServiceEntity(
            $value['ServiceId'] ?? null,
            $value['ServiceName'] ?? null,
            $value['ServiceSlug'] ?? null,
            $value['ServiceDescription'] ?? null,

            isset($value['ServiceId']) ? $this->serviceImage($value['ServiceId']) : null,
            isset($value['ServiceId']) ? $this->serviceText($value['ServiceId']) : null,
            isset($value['ServiceId']) ? $this->serviceFaqs($value['ServiceId']) : null,
        );

    }

    public function serviceImage(int $num)
    {
        $serviceImageModel = new ServiceImageModel();
        $query = $serviceImageModel->query($serviceImageModel->sqlFile, [
            'serviceId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new ServiceImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $arr['FileManagerFileName'],
            $arr['FileManagerFileName'] ?? null,
        );

        return $entity;
    }

    public function serviceText(int $num)
    {
        $serviceTextModel = new ServiceTextModel();
        $query = $serviceTextModel->query($serviceTextModel->sqlText, [
            'serviceId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new ServiceTextEntity(
            $num,
            $arr['ServiceText'] ?? null
        );

        return $entity;
    }

    public function serviceFaqs(int $num)
    {
        $serviceFaqModel = new ServiceFaqModel();
        $query = $serviceFaqModel->query($serviceFaqModel->sqlServiceFaq, [
            'serviceId' => $num,
        ]);
        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ServiceFaqEntity(
                $row['ServiceFaqId'],
                $row['ServiceId'] ?? null,
                $row['ServiceFaqQuestion'] ?? null,
                $row['ServiceFaqAnswer'] ?? null,
            );

            $arr[$row['ServiceFaqId']] = $entity;
        }


        return $arr;
    }



}