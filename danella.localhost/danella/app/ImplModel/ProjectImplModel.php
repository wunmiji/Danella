<?php

namespace App\ImplModel;


use App\Models\Project\ProjectModel;
use App\Models\Project\ProjectImageModel;
use App\Models\Project\ProjectTextModel;
use App\Models\Project\ProjectServiceModel;
use App\Models\Project\ProjectGallaryModel;
use App\Entities\Project\ProjectEntity;
use App\Entities\Project\ProjectImageEntity;
use App\Entities\Project\ProjectTextEntity;
use App\Entities\Project\ProjectServiceEntity;
use App\Entities\Project\ProjectGallaryEntity;


/**
 * 
 */

class ProjectImplModel
{


    public function list(int $from, int $to)
    {
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->sqlList, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProjectEntity(
                $value['ProjectId'],
                $value['ProjectName'] ?? null,
                $value['ProjectSlug'] ?? null,
                null,
                null,
                null,
    
                isset($value['ProjectId']) ? $this->projectImage($value['ProjectId']) : null,
                null,
                null,
                null,
            );

            array_push($output, $entity);
        }

        return $output;
    }

    public function slug(string $slug)
    {
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->sqlSlug, [
            'slug' => $slug,
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
            $value['ProjectLocation'] ?? null,
            $value['ProjectDate'] ?? null,
            $value['ProjectClient'] ?? null,

            isset($value['ProjectId']) ? $this->projectImage($value['ProjectId']) : null,
            isset($value['ProjectId']) ? $this->projectText($value['ProjectId']) : null,
            isset($value['ProjectId']) ? $this->projectServices($value['ProjectId']) : null,
            isset($value['ProjectId']) ? $this->projectGallary($value['ProjectId']) : null,
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
                $row['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $row['FileManagerFileName'],
                $row['FileManagerFileName'] ?? null,
                $row['FileManagerFileMimeType'] ?? null,
            );

            $arr[$row['ProjectGallaryId']] = $entity;
        }

        return $arr;
    }


    // Other 
    public function count()
    {
        $projectModel = new ProjectModel();
        $query = $projectModel->query($projectModel->sqlCount);
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