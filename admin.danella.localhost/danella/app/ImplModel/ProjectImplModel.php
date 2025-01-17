<?php

namespace App\ImplModel;


use App\Enums\FileType;
use App\Models\Project\ProjectModel;
use App\Models\Project\ProjectImageModel;
use App\Models\Project\ProjectTextModel;
use App\Models\Project\ProjectServiceModel;
use App\Models\Project\ProjectGallaryModel;
use App\Models\Project\ProjectFilesModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Entities\Project\ProjectEntity;
use App\Entities\Project\ProjectImageEntity;
use App\Entities\Project\ProjectTextEntity;
use App\Entities\Project\ProjectServiceEntity;
use App\Entities\Project\ProjectGallaryEntity;
use App\Entities\Project\ProjectFilesEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class ProjectImplModel
{


    public function list(int $from, int $to)
    {
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProjectEntity(
                $value['ProjectId'] ?? null,
                $value['ProjectName'] ?? null,
                null,
                $value['ProjectStatus'] ?? null,
                null,
                null,
                $value['ProjectClient'] ?? null,

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
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function projectPerMonth(int $year)
    {
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->projectPerMonth, [
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
        
        // Sort array based on
        // usort($list, function ($a, $b) {
        //     $monthA = date_parse($a['x']);
        //     $monthB = date_parse($b['x']);

        //     return $monthA["month"] - $monthB["month"];
        // });

        return json_encode($list);
    }

    public function retrieve(int $num)
    {
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->sqlRetrieve, [
            'projectId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->project($row);
        }
    }

    public function project($value)
    {
        return new ProjectEntity(
            $value['ProjectId'] ?? null,
            $value['ProjectName'] ?? null,
            $value['ProjectSlug'] ?? null,
            $value['ProjectStatus'] ?? null,
            $value['ProjectLocation'] ?? null,
            DateLibrary::getDate($value['ProjectDate']) ?? null,
            $value['ProjectClient'] ?? null,

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            (isset($value['ProjectId'])) ? $this->projectText($value['ProjectId']) : null,
            (isset($value['ProjectId'])) ? $this->projectImage($value['ProjectId']) : null,
            (isset($value['ProjectId'])) ? $this->projectServices($value['ProjectId']) : null,
            (isset($value['ProjectId'])) ? $this->projectGallary($value['ProjectId']) : null,
            (isset($value['ProjectId'])) ? $this->projectFiles($value['ProjectId']) : null,
        );

    }

    public function projectImage(int $num)
    {
        $projectFileModel = new ProjectImageModel();
        $query = $projectFileModel->query($projectFileModel->sqlFile, [
            'projectId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new ProjectImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $arr['FileManagerFileName'],
            $arr['FileManagerFileName'] ?? null,
        );

        return $entity;
    }

    public function projectText(int $num)
    {
        $projectTextModel = new ProjectTextModel();
        $query = $projectTextModel->query($projectTextModel->sqlText, [
            'projectId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new ProjectTextEntity(
            $num,
            $arr['ProjectText'] ?? null
        );

        return $entity;
    }

    public function projectServices(int $num)
    {
        $projectServiceModel = new ProjectServiceModel();
        $query = $projectServiceModel->query($projectServiceModel->sqlService, [
            'projectId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProjectServiceEntity(
                $row['Id'],
                $row['ProjectId'] ?? null,
                $row['ServiceId'] ?? null,
                $row['ServiceName'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function projectGallary(int $num)
    {
        $projectGallaryModel = new ProjectGallaryModel();
        $query = $projectGallaryModel->query($projectGallaryModel->sqlGallary, [
            'projectId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProjectGallaryEntity(
                $row['ProjectGallaryId'] ?? null,
                $row['ProjectId'] ?? null,
                $row['FileId'] ?? null,
                $row['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $row['FileManagerFileName'],
                $row['FileManagerFileName'] ?? null,
                $row['FileManagerFileMimeType'] ?? null,
            );

            $arr[$row['ProjectGallaryId']] = $entity;
        }

        return $arr;
    }

    public function projectFiles(int $num)
    {
        $projectFilesModel = new ProjectFilesModel();
        $query = $projectFilesModel->query($projectFilesModel->sqlFiles, [
            'projectId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProjectFilesEntity(
                $row['ProjectFilesId'] ?? null,
                $row['ProjectId'] ?? null,
                $row['FileId'] ?? null,
                $row['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $row['FileManagerFileName'],
                $row['FileManagerFileName'] ?? null,
                $row['FileManagerFileMimeType'] ?? null,
                $row['FileManagerId'] ?? null,
                $row['FileManagerName'] ?? null
            );

            $arr[$row['ProjectFilesId']] = $entity;
        }

        return $arr;
    }

    public function save($data, $dataImage, $dataText, $dataServices, $dataGallary)
    {
        try {

            $projectModel = new ProjectModel();

            $projectModel->transException(true)->transStart();

            // Insert into project
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $projectId = $projectModel->insert($data);

            // Insert into project_image
            $dataImage['ProjectId'] = $projectId;
            $projectImageModel = new ProjectImageModel();
            $projectImageModel->insert($dataImage);

            // Insert into projext_text
            $dataText['ProjectId'] = $projectId;
            $projectTextModel = new ProjectTextModel();
            $projectTextModel->insert($dataText);

            // Insert into project_service
            $projectServiceModel = new ProjectServiceModel();
            foreach ($dataServices as $service) {
                $service['ProjectServiceProjectFk'] = $projectId;
                $projectServiceModel->insert($service);
            }

            // Insert into project_gallary
            $projectGallaryModel = new ProjectGallaryModel();
            foreach ($dataGallary as $gallary) {
                $gallary['ProjectGallaryProjectFk'] = $projectId;
                $projectGallaryModel->insert($gallary);
            }

            $projectModel->transComplete();

            if ($projectModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function update($num, $data, $dataImage, $dataText, $dataServices, $dataGallary)
    {
        try {
            $projectModel = new ProjectModel();

            $projectModel->transException(true)->transStart();

            // Update into project
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $projectModel->update($num, $data);

            // Update into project_text
            $projectTextModel = new ProjectTextModel();
            $projectTextModel->update($num, $dataText);

            // Update into project_image
            $projectImageModel = new ProjectImageModel();
            $projectImageModel->update($num, $dataImage);

            // Update into project_service
            $projectServiceModel = new ProjectServiceModel();
            $beforeAll = $projectServiceModel->where('ProjectServiceProjectFk', $num)->findAll();
            $beforeAllColumn = array_column($beforeAll, 'ProjectServiceId');
            $dataServicesColumn = array_column($dataServices, 'ProjectServiceId');
            $diffArray = ArrayLibrary::getOneToMany($beforeAllColumn, $dataServicesColumn);
            foreach ($diffArray as $diff) {
                $projectServiceModel->delete(intval($diff));
            }
            foreach ($dataServices as $dataService) {
                $projectServiceModel->save($dataService);
            }

            // Update into project_gallary
            $projectGallaryModel = new ProjectGallaryModel();
            $beforeAll = $projectGallaryModel->where('ProjectGallaryProjectFk', $num)->findAll();
            $beforeAllColumn = array_column($beforeAll, 'ProjectGallaryId');
            $dataGallaryColumn = array_column($dataGallary, 'ProjectGallaryId');
            $diffArray = ArrayLibrary::getOneToMany($beforeAllColumn, $dataGallaryColumn);
            foreach ($diffArray as $diff) {
                $projectGallaryModel->delete(intval($diff));
            }
            foreach ($dataGallary as $gallary) {
                $projectGallaryModel->save($gallary);
            }

            $projectModel->transComplete();

            if ($projectModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function updateFiles($num, $data, $dataFiles)
    {
        try {
            $projectModel = new ProjectModel();

            $projectModel->transException(true)->transStart();

            // Update into project
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $projectModel->update($num, $data);

            // Update into project_files
            $projectFilesModel = new ProjectFilesModel();
            $beforeAll = $projectFilesModel->where('ProjectFilesProjectFk', $num)->findAll();
            $beforeAllColumn = array_column($beforeAll, 'ProjectFilesId');
            $dataFilesColumn = array_column($dataFiles, 'ProjectFilesId');
            $diffArray = ArrayLibrary::getOneToMany($beforeAllColumn, $dataFilesColumn);
            foreach ($diffArray as $diff) {
                $projectFilesModel->delete(intval($diff));
            }
            foreach ($dataFiles as $files) {
                $projectFilesModel->save($files);
            }

            $projectModel->transComplete();

            if ($projectModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            d($e->getCode());
            die;
            //return $e->getCode();
        }
    }

    public function delete(int $num)
    {
        try {
            $projectModel = new ProjectModel();
            $projectModel->transException(true)->transStart();

            $query = $projectModel->query($projectModel->sqlDelete, [
                'projectId' => $num,
            ]);

            $affected_rows = $projectModel->affectedRows();

            $projectModel->transComplete();
            if ($affected_rows >= 1 && $projectModel->transStatus() === true)
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
            $projectModel = new ProjectModel();
            $projectModel->transException(true)->transStart();

            $query = $projectModel->query($projectModel->sqlStatus, [
                'projectId' => $num,
            ]);
            $row = $query->getRowArray();
            if (is_null($row))
                return false;


            $data['ProjectStatus'] = (boolval($row['ProjectStatus']) === true) ? false : true;
            $data['ModifiedId'] = $employeeId;
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $projectModel->update($num, $data);

            $projectModel->transComplete();
            if ($projectModel->transStatus() === true)
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
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->sqlCount);
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