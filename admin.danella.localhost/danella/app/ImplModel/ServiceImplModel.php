<?php

namespace App\ImplModel;


use App\Models\Service\ServiceModel;
use App\Models\Service\ServiceImageModel;
use App\Models\Service\ServiceTextModel;
use App\Models\Service\ServiceFaqModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Entities\Service\ServiceEntity;
use App\Entities\Service\ServiceTextEntity;
use App\Entities\Service\ServiceImageEntity;
use App\Entities\Service\ServiceFaqEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class ServiceImplModel
{


    public function list(int $from, int $to)
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ServiceEntity(
                $value['ServiceId'] ?? null,
                $value['ServiceName'] ?? null,
                null,
                null,
                $value['ServiceStatus'] ?? null,

                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listNameJson()
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlServiceName);
        $list = $query->getResultArray();

        return json_encode($list);
    }

    public function serviceNameChart()
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlServiceNameChart);
        $list = $query->getResultArray();

        return json_encode($list);
    }

    public function servicePerProject()
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlServicePerProject);
        $list = $query->getResultArray();

        return json_encode(array_column($list, 'x'));
    }

    public function servicePerBlog()
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlServicePerBlog);
        $list = $query->getResultArray();

        return json_encode(array_column($list, 'x'));
    }

    public function servicePerProjectStatus($status)
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlServicePerProjectStaus, [
            'status' => $status
        ]);
        $list = $query->getResultArray();

        return json_encode($list);
    }


    public function retrieve(int $num)
    {
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlService, [
            'serviceId' => $num,
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
            $value['ServiceStatus'] ?? null,

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] . ' ' . $value['CreatedByLastName'],
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] . ' ' . $value['ModifiedByLastName'],
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->serviceImage($value['ServiceId']) ?? null,
            $this->serviceText($value['ServiceId']) ?? null,
            $this->serviceFaqs($value['ServiceId']) ?? null,
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

    public function save($data, $dataImage, $dataText, $dataFaqs)
    {
        try {
            $serviceModel = new ServiceModel();

            $serviceModel->transException(true)->transStart();

            // Insert into service
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();;
            $serviceId = $serviceModel->insert($data);

            // Insert into service_image
            $dataImage['ServiceId'] = $serviceId;
            $serviceImageModel = new ServiceImageModel();
            $serviceImageModel->insert($dataImage);

            // Insert into service_text
            $dataText['ServiceId'] = $serviceId;
            $serviceTextModel = new ServiceTextModel();
            $serviceTextModel->insert($dataText);

            // Insert into service_faq
            $serviceFaqModel = new ServiceFaqModel();
            foreach ($dataFaqs as $dataFaq) {
                $dataFaq['ServiceFaqServiceFk'] = $serviceId;
                $serviceFaqModel->insert($dataFaq);
            }

            $serviceModel->transComplete();

            if ($serviceModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function update($num, $data, $dataImage, $dataText, $dataFaqs)
    {
        try {
            $serviceModel = new ServiceModel();

            $serviceModel->transException(true)->transStart();

            // Update into service
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();;
            $serviceModel->update($num, $data);

            // Update into service_image
            $serviceImageModel = new ServiceImageModel();
            $serviceImageModel->update($num, $dataImage);

            // Update into service_text
            $serviceTextModel = new ServiceTextModel();
            $serviceTextModel->update($num, $dataText);

            // Update into service_faq
            $serviceFaqModel = new ServiceFaqModel();
            $beforeAll = $serviceFaqModel->where('ServiceFaqServiceFk', $num)->findAll();
            $beforeAllColumn = array_column($beforeAll, 'ServiceFaqId');
            $dataFaqsColumn = array_column($dataFaqs, 'ServiceFaqId');
            $diffArray = ArrayLibrary::getOneToMany($beforeAllColumn, $dataFaqsColumn);
            foreach ($diffArray as $diff) {
                $serviceFaqModel->delete(intval($diff));
            }
            foreach ($dataFaqs as $dataFaq) {
                $serviceFaqModel->save($dataFaq);
            }

            // transaction completed
            $serviceModel->transComplete();

            if ($serviceModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function delete(int $num)
    {
        try {
            $serviceModel = new ServiceModel();
            $serviceModel->transException(true)->transStart();

            $query = $serviceModel->query($serviceModel->sqlDelete, [
                'serviceId' => $num,
            ]);

            $affected_rows = $serviceModel->affectedRows();

            $serviceModel->transComplete();
            if ($affected_rows >= 1 && $serviceModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function status(int $num, int $employeeId)
    {
        try {
            $serviceModel = new ServiceModel();
            $serviceModel->transException(true)->transStart();

            $query = $serviceModel->query($serviceModel->sqlStatus, [
                'serviceId' => $num,
            ]);
            $row = $query->getRowArray();
            if (is_null($row))
                return false;

            
            $data['ServiceStatus'] = (boolval($row['ServiceStatus']) === true) ? false : true; 
            $data['ModifiedId'] = $employeeId;
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $serviceModel->update($num, $data);

            $serviceModel->transComplete();
            if ($serviceModel->transStatus() === true)
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
        $serviceModel = new ServiceModel();
        $query = $serviceModel->query($serviceModel->sqlCount);
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