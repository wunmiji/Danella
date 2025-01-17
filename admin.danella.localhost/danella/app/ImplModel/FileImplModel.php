<?php

namespace App\ImplModel;


use App\Libraries\FileLibrary;
use App\Models\File\FileModel;
use App\Libraries\DateLibrary;
use App\Entities\File\FileEntity;

use CodeIgniter\Database\Exceptions\DatabaseException;

use Ramsey\Uuid\Uuid;


/**
 * 
 */

class FileImplModel
{

    public $namespace = '9597c04a-10cb-11ef-b01a-a0d3c198cfa0';
    public $fileManager = '4c0c7bf3-686f-5b42-8098-7554aa90f346'; // name = 'file-manager'

    public function list()
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlTable);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileEntity(
                $value['FileId'] ?? null,
                null,
                null,
                $value['FileName'] ?? null,
                $value['FileIsDirectory'] ?? null,
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
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function fileManager(string $publicId)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlFileManager, [
            'publicId' => $publicId
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'],
                null,
                null,
                null,
                $value['FilePath'],
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
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrievePrivate(string $privateId)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlRetrievePrivate, [
            'privateId' => $privateId
        ]);
        $value = $query->getRowArray();

        if (is_null(($value)))
            return null;
        else {
            return new FileEntity(
                $value['FileId'],
                null,
                $value['FilePublicId'],
                $value['FileName'],
                $value['FileIsDirectory'],
                null,
                null,
                $value['FilePath'],
                $value['FileParentPath'],
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

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
        }

    }

    public function retrieve(string $publicId)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlRetrieveAll, [
            'publicId' => $publicId,
        ]);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $value) {
            $lastModifiedTimeStamp = intval($value['FileLastModified']);
            $modifiedDateTimeTimeStamp =  DateLibrary::toTimestamp($value['ModifiedDateTime']);
            
            $entity = new FileEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'] ?? null,
                ($value['FileIsDirectory'] == 1) ? true : false,
                $value['FileUrlPath'] ?? null,
                $value['FileDescription'] ?? null,
                $value['Path'] ?? null,
                $value['ParentPath'] ?? null,
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                $value['FileMimeType'],
                ($value['FileIsDirectory'] == 1) ? $value['FileSize'] . ' items' : FileLibrary::formatBytes($value['FileSize']),
                $value['FileExtension'],
                ($modifiedDateTimeTimeStamp > $lastModifiedTimeStamp) ? DateLibrary::formatTimestamp($modifiedDateTimeTimeStamp) : DateLibrary::formatTimestamp($lastModifiedTimeStamp),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $value['ModifiedId'] ?? null,
                $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
                DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }

        //die;

        return $output;
    }

    public function retrieveFavorite()
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlRetrieveFavorite);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $value) {
            $entity = new FileEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'] ?? null,
                ($value['FileIsDirectory'] == 1) ? true : false,
                $value['FileUrlPath'] ?? null,
                $value['FileDescription'] ?? null,
                $value['Path'] ?? null,
                $value['ParentPath'] ?? null,
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                $value['FileMimeType'],
                ($value['FileIsDirectory'] == 1) ? $value['FileSize'] . ' items' : FileLibrary::formatBytes($value['FileSize']),
                $value['FileExtension'],
                DateLibrary::formatTimestamp($value['FileLastModified']),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $value['ModifiedId'] ?? null,
                $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
                DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }


        return $output;
    }

    public function retrieveTrash()
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlRetrieveTrash);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $value) {
            $entity = new FileEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'] ?? null,
                ($value['FileIsDirectory'] == 1) ? true : false,
                $value['FileUrlPath'] ?? null,
                $value['FileDescription'] ?? null,
                $value['Path'] ?? null,
                $value['ParentPath'] ?? null,
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                $value['FileMimeType'],
                ($value['FileIsDirectory'] == 1) ? $value['FileSize'] . ' items' : FileLibrary::formatBytes($value['FileSize']),
                $value['FileExtension'],
                DateLibrary::formatTimestamp($value['FileLastModified']),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $value['ModifiedId'] ?? null,
                $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
                DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }


        return $output;
    }

    public function retrieveFolder(string $privateId)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlSimpleRetrieve, [
            'privateId' => $privateId,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return new FileEntity(
                $row['FileId'],
                $row['FilePrivateId'],
                null,
                $row['FileName'],
                null,
                null,
                $row['FileDescription'],
                $row['FilePath'],
                $row['FileParentPath'],
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
        }
    }

    public function retrievePaths(string $publicId)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlUpdateOther, [
            'publicId' => $publicId,
        ]);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $row) {
            $entity = new FileEntity(
                $row['FileId'],
                null,
                null,
                null,
                $row['FileIsDirectory'],
                $row['FileUrlPath'],
                null,
                $row['FilePath'],
                $row['FileParentPath'],
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


    public function saveFolder($data)
    {
        try {
            $fileModel = new FileModel();

            $fileModel->transException(true)->transStart();

            // Insert into file
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $fileId = $fileModel->insert($data);

            //Update file with privateId
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $fileId);
            $dataUpdated['FilePrivateId'] = $uuid->toString();
            $fileModel->update($fileId, $dataUpdated);

            $fileModel->transComplete();

            if ($fileModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function saveFile($datas)
    {
        try {
            $fileModel = new FileModel();

            $fileModel->transException(true)->transStart();
            $dateTime = DateLibrary::getZoneDateTime();

            // Insert into file
            foreach ($datas as $data) {
                $data['CreatedDateTime'] = $dateTime;
                $fileId = $fileModel->insert($data);

                //Update file with privateId
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $fileId);
                $dataUpdated['FilePrivateId'] = $uuid->toString();
                $fileModel->update($fileId, $dataUpdated);
            }


            $fileModel->transComplete();

            if ($fileModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function updateFolder($num, $data, $childFiles)
    {
        try {
            $fileModel = new FileModel();

            $fileModel->transException(true)->transStart();

            // Update into file
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileId = $fileModel->update($num, $data);

            // Update childFiles
            foreach ($childFiles as $key => $value) {
                $value['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
                $fileModel->update($key, $value);
            }

            $fileModel->transComplete();

            if ($fileModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function renameFile($num, $data)
    {
        try {
            $fileModel = new FileModel();

            $fileModel->transException(true)->transStart();

            // Rename file
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileId = $fileModel->update($num, $data);

            $fileModel->transComplete();

            if ($fileModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function favourite(int $num)
    {
        try {
            $fileModel = new FileModel();
            $fileModel->transException(true)->transStart();

            $query = $fileModel->query($fileModel->sqlFavourite, [
                'fileId' => $num,
            ]);

            $affected_rows = $fileModel->affectedRows();

            $fileModel->transComplete();
            if ($affected_rows >= 1 && $fileModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function trash(int $num, $data)
    {
        try {
            $fileModel = new FileModel();

            $fileModel->transException(true)->transStart();

            // Update into file
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $data['ModifiedId'] = session()->get('employeeId');
            $fileId = $fileModel->update($num, $data);

            $affected_rows = $fileModel->affectedRows();

            $fileModel->transComplete();
            if ($affected_rows >= 1 && $fileModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function deleteFolder(int $num, string $path)
    {
        try {
            $fileModel = new FileModel();
            $fileModel->transException(true)->transStart();

            $query = $fileModel->query($fileModel->sqlDelete, [
                'fileId' => $num,
            ]);

            $children = $this->sqlAllFolderChildren($path);
            foreach ($children as $key => $value) {
                $fileModel->delete($value['Id']);
            }
            

            $affected_rows = $fileModel->affectedRows();

            $fileModel->transComplete();
            if ($affected_rows >= 1 && $fileModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function deleteFile(int $num)
    {
        try {
            $fileModel = new FileModel();

            $fileModel->transException(true)->transStart();

            $query = $fileModel->query($fileModel->sqlDelete, [
                'fileId' => $num,
            ]);

            $affected_rows = $fileModel->affectedRows();

            $fileModel->transComplete();
            if ($affected_rows >= 1 && $fileModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            //return $e->getCode();
            d($e);
        }
    }

    public function folderPath($num)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlFolderPath, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FilePath'};
    }


    // Other 
    public function getFileManagerPrivateId()
    {
        return $this->fileManager;
    }


    public function count()
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlCount);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function getFileId(string $publicId, string $name)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlWherePublicIdName, [
            'publicId' => $publicId,
            'name' => $name
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function sqlAllFolderChildren(string $filePath)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlAllFolderChildren, [
            'filePath' => $filePath . '%'
        ]);
        return $query->getResultArray();
    }

    public function getPrivateId(string $filePath)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlWhereFilePath, [
            'filePath' => $filePath
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FilePrivateId'};
    }

    public function countFiles(int $num)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlCountFiles, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT(*)'};
    }

    public function sumAllFileSize()
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlSumAllFileSize);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'SUM(FileSize)'};
    }

    public function sumFileSize(int $num)
    {
        $fileModel = new FileModel();
        $query = $fileModel->query($fileModel->sqlSumFileSize, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : FileLibrary::formatBytes($row->{'SUM(FileSize)'});
    }


}