<?php

namespace App\ImplModel;


use App\Libraries\FileLibrary;
use App\Models\FileManager\FileManagerModel;
use App\Models\FileManager\FileManagerFileModel;
use App\Libraries\DateLibrary;
use App\Entities\FileManager\FileManagerEntity;
use App\Entities\FileManager\FileManagerFileEntity;
use App\Enums\FileType;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class FileManagerImplModel
{

    public $maxFileManagerSize; // 5368709120 (5gb)

    public function __construct()
    {
        $this->maxFileManagerSize = disk_total_space("/") / 2100;
    }

    public function list(int $from, int $to)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileManagerEntity(
                $value['FileManagerId'] ?? null,
                $value['FileManagerName'] ?? null,
                $value['FileManagerType'],
                FileType::getValue($value['FileManagerType']),
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

    public function retrieve(int $num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlRetrieve, [
            'fileManagerId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->fileManager($row);
        }
    }

    public function retrieveFolder(int $num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlSimpleRetrieve, [
            'fileManagerId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return new FileManagerEntity(
                $row['FileManagerId'] ?? null,
                $row['FileManagerName'] ?? null,
                $row['FileManagerType'],
                FileType::getValue($row['FileManagerType']),
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
            ;
        }
    }

    public function filePath(int $num)
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlFilePath, [
            'fileManagerFileId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return new FileManagerFileEntity(
                null,
                $row['FileManagerPath'],
                $row['FileManagerPath'] . DIRECTORY_SEPARATOR . $row['FileManagerFileName'],
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
        }
    }

    public function retrieveFileList(int $num)
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlList, [
            'fileManagerId' => $num,
        ]);
        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new FileManagerFileEntity(
                $row['FileManagerFileId'],
                null,
                null,
                $row['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $row['FileManagerFileName'],
                $row['FileManagerFileName'],
                $row['FileManagerFileMimeType'],
                null,
                null,
                null,

                null,
                null,
                null,
            );

            array_push($arr, $entity);
        }

        return $arr;
    }

    public function listFolderFile(int $num)
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlFile, [
            'fileManagerId' => $num,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileManagerFileEntity(
                $value['FileManagerFileId'],
                $value['FileManagerPath'],
                $value['FileManagerPath'] . DIRECTORY_SEPARATOR . $value['FileManagerFileName'],
                $value['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $value['FileManagerFileName'],
                $value['FileManagerFileName'],
                $value['FileManagerFileMimeType'],
                FileLibrary::formatBytes($value['FileManagerFileSize']),
                $value['FileManagerFileExtension'],
                DateLibrary::formatTimestamp($value['FileManagerFileLastModified']),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }

        return $output;
    }

    public function ListPublicFoldersWithFiles()
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlList, [
            'type' => FileType::PUBLIC ->name,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileManagerEntity(
                $value['FileManagerId'] ?? null,
                $value['FileManagerName'] ?? null,
                null,
                null,
                null,
                null,
                $value['FileManagerPath'] ?? null,

                null,
                null,
                null,

                null,
                null,
                null,

                $this->retrieveFileList($value['FileManagerId'])
            );

            array_push($output, $entity);
        }

        return $output;
    }

    public function ListPrivateFoldersWithFiles()
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlList, [
            'type' => FileType::PRIVATE ->name,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileManagerEntity(
                $value['FileManagerId'] ?? null,
                $value['FileManagerName'] ?? null,
                null,
                null,
                null,
                null,
                $value['FileManagerPath'] ?? null,

                null,
                null,
                null,

                null,
                null,
                null,

                $this->retrieveFileList($value['FileManagerId'])
            );

            array_push($output, $entity);
        }

        return $output;
    }

    public function fileManager($value)
    {
        return new FileManagerEntity(
            $value['FileManagerId'] ?? null,
            $value['FileManagerName'] ?? null,
            $value['FileManagerType'],
            FileType::getValue($value['FileManagerType']),
            $value['FileManagerUrlPath'] ?? null,
            $value['FileManagerDescription'] ?? null,
            $value['FileManagerPath'] ?? null,

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            null,
        );


    }

    public function saveFolder($data)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            // Insert into fileManager
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $fileManagerId = $fileManagerModel->insert($data);

            $fileManagerModel->transComplete();

            if ($fileManagerModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function saveFile($folderNum, $folder, $datas)
    {
        try {
            $fileManagerFileModel = new FileManagerFileModel();

            $fileManagerFileModel->transException(true)->transStart();
            $dateTime = DateLibrary::getZoneDateTime();

            // Insert into fileManager
            foreach ($datas as $data) {
                $data['CreatedDateTime'] = $dateTime;
                $fileManagerId = $fileManagerFileModel->insert($data);
            }

            // Update into fileManager
            $folder['ModifiedDateTime'] = $dateTime;
            $fileManagerModel = new FileManagerModel();
            $fileManagerId = $fileManagerModel->update($folderNum, $folder);

            $fileManagerFileModel->transComplete();

            if ($fileManagerFileModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function updateFolder($num, $data)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            // Update into fileManager
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileManagerId = $fileManagerModel->update($num, $data);

            $fileManagerModel->transComplete();

            if ($fileManagerModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function renameFile($fileNum, $folderNum, $folder, $data)
    {
        try {
            $fileManagerFileModel = new FileManagerFileModel();

            $fileManagerFileModel->transException(true)->transStart();

            // Rename file
            $fileManagerId = $fileManagerFileModel->update($fileNum, $data);

            // Update into fileManager
            $folder['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileManagerModel = new FileManagerModel();
            $fileManagerId = $fileManagerModel->update($folderNum, $folder);

            $fileManagerFileModel->transComplete();

            if ($fileManagerFileModel->transStatus() === false)
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
            $fileManagerModel = new FileManagerModel();
            $fileManagerModel->transException(true)->transStart();

            $query = $fileManagerModel->query($fileManagerModel->sqlDelete, [
                'fileManagerId' => $num,
            ]);

            $affected_rows = $fileManagerModel->affectedRows();

            $fileManagerModel->transComplete();
            if ($affected_rows >= 1 && $fileManagerModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function deleteFile(int $fileNum, $folderNum, $folder)
    {
        try {
            $fileManagerFileModel = new FileManagerFileModel();
            $fileManagerFileModel->transException(true)->transStart();

            $query = $fileManagerFileModel->query($fileManagerFileModel->sqlDelete, [
                'fileManagerFileId' => $fileNum,
            ]);

            // Update into fileManager
            $folder['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileManagerModel = new FileManagerModel();
            $fileManagerId = $fileManagerModel->update($folderNum, $folder);

            $affected_rows = $fileManagerFileModel->affectedRows();

            $fileManagerFileModel->transComplete();
            if ($affected_rows >= 1 && $fileManagerFileModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function folderPath($num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlFolderPath, [
            'fileManagerId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FileManagerPath'};
    }


    // Other 
    public function count()
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlCount);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function getFileId(int $num)
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlId, [
            'fileManagerFileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FileManagerFileId'};
    }

    public function countFiles(int $num)
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlCountFiles, [
            'fileManagerId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT(*)'};
    }

    public function sumAllFileSize()
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlSumAllFileSize);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'SUM(FileManagerFileSize)'};
    }

    public function sumFileSize(int $num)
    {
        $fileManagerFileModel = new FileManagerFileModel();
        $query = $fileManagerFileModel->query($fileManagerFileModel->sqlSumFileSize, [
            'fileManagerId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : FileLibrary::formatBytes($row->{'SUM(FileManagerFileSize)'});
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