<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\FileImplModel;
use App\Libraries\FileLibrary;
use App\Enums\FileType;

use Cocur\Slugify\Slugify;
use Ramsey\Uuid\Uuid;
use Sentry\Breadcrumb;

class File extends BaseController
{
    protected $maxFileSize; // 5368709120 (5gb)

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 50'
            ]
        ]
    ];

    protected $fieldAlternate = [
        'alternate' => [
            'rules' => 'max_length[100]',
            'errors' => [
                'max_length' => 'Max length for alternate is 100'
            ]
        ]
    ];

    protected $fieldDescription = [
        'description' => [
            'rules' => 'required|max_length[150]',
            'errors' => [
                'required' => 'Description is required',
                'max_length' => 'Max length for description is 150'
            ]
        ]
    ];

    protected $fieldFiles = [
        'files' => [
            'rules' => 'uploaded[files]|max_size[files,20480]|mime_in[files,image/apng,image/avif,image/gif,image/webp,image/svg+xml,image/png,image/jpeg,image/jpg,video/mp4,text/plain,text/csv,application/pdf,application/msword,audio/mpeg,audio/ogg,application/zip,text/richtext]',
            'errors' => [
                'uploaded' => 'Files is required',
                'max_size' => 'Max files size is 20mb',
                'mime_in' => 'Mime type not allowed',
            ]
        ]
    ];

    protected $fieldFileName = [
        'name' => [
            'rules' => 'required|regex_match[/^[\w\-. ]+$/]',
            'errors' => [
                'required' => 'Name is required',
                'regex_match' => 'Name is not valid',
            ]
        ]
    ];

    public function __construct()
    {
        helper(['url', 'form']);
        $this->maxFileSize = disk_total_space("/");
    }

    public function index()
    {
        try {
            $fileImplModel = new FileImplModel();

            return redirect()->to('file-managerr/' . $fileImplModel->getFileManagerPrivateId());
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function indexDanellatech(string $privateId)
    {
        try {
            $fileImplModel = new FileImplModel();

            $this->createPlace($fileImplModel, $fileImplModel->getFileManagerPrivateId(), 'Home', 'Home');
            $this->createPlace($fileImplModel, $fileImplModel->getFileManagerPrivateId(), 'Documents', 'Documents');
            $this->createPlace($fileImplModel, $fileImplModel->getFileManagerPrivateId(), 'Pictures', 'Pictures');
            $this->createPlace($fileImplModel, $fileImplModel->getFileManagerPrivateId(), 'Videos', 'Videos');


            $breadCrumbArray = array();
            $breadCrumbArray[$fileImplModel->getFileManagerPrivateId()] = 'File Manager';
            if ($this->request->isAJAX()) {
                if ($privateId == 'Favourite') {
                    // Retrieve all files in favourite
                    $files = $fileImplModel->retrieveFavorite();
                    $breadCrumbArray[0] = 'Favourite';

                    $data = [
                        'breadcrumb' => $breadCrumbArray,
                        'files' => $files
                    ];

                    return json_encode($data);
                } else {
                    $breadCrumbArray = $this->breadCrumb($fileImplModel, $privateId, $breadCrumbArray);

                    // Retrieve all files in privateId
                    $files = $fileImplModel->retrieve($privateId);

                    $data = [
                        'breadcrumb' => $breadCrumbArray,
                        'files' => $files
                    ];

                    return json_encode($data);
                }
            }

            // Get All Places
            $places = $fileImplModel->fileManager($fileImplModel->getFileManagerPrivateId());

            $files = array();
            if ($privateId == 'Favourite') {
                // Retrieve all files in favourite
                $files = $fileImplModel->retrieveFavorite();
                $breadCrumbArray[0] = 'Favourite';
            } elseif ($privateId == 'Trash') {
                // Retrieve all files in trash
                $files = $fileImplModel->retrieveTrash();
                $breadCrumbArray[0] = 'Trash';
            } else {
                $breadCrumbArray = $this->breadCrumb($fileImplModel, $privateId, $breadCrumbArray);

                // Retrieve all files in privateId
                $files = $fileImplModel->retrieve($privateId);
            }


            $data['title'] = 'File Manager';
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>' .
                '<script src="/assets/js/custom/infoo_modal.js"></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/filess_modal.js"></script>' .
                '<script src="/assets/js/custom/renamee_modal.js"></script>';
            $data['datas'] = $files;
            $data['places'] = $places;
            $data['dataPrivateId'] = $privateId;
            $data['dataFileManagerPrivateId'] = $fileImplModel->getFileManagerPrivateId();
            $data['dataBreadCrumbArray'] = $breadCrumbArray;

            return view('file/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function createFolder(string $privateId, $validator = null)
    {
        try {

            $data['title'] = 'New Folder';
            $data['validation'] = $validator;
            $data['dataPrivateId'] = $privateId;

            return view('file/create-folder', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }

    public function createPlace(FileImplModel $fileImplModel, string $publicId, string $name, string $description)
    {
        try {
            if (is_null($fileImplModel->getFileId($publicId, $name))) {
                $folder = FileLibrary::$dir . $name;
                $data = [
                    'FilePublicId' => $publicId,
                    'FileName' => $name,
                    'FileIsDirectory' => true,
                    'FileParentPath' => FileLibrary::$dir,
                    'FileDescription' => $description,
                    'FilePath' => $folder,
                    'CreatedId' => session()->get('employeeId'),
                ];

                if ($fileImplModel->saveFolder($data)) {
                    FileLibrary::createFolder($folder);
                } else
                    return redirect()->back()->with('fail', 'An error occur when adding' . $name . 'folder!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }

    public function createFile(string $privateId, $validator = null)
    {
        try {
            $data['title'] = 'New File';

            $acceptedFileInput = 'application/pdf, application/msword, application/zip, text/*, audio/*, video/*, image/*';

            $data['js_files'] = '<script src="/assets/js/custom/file_manager.js"></script>';
            $data['validation'] = $validator;
            $data['acceptedFileInput'] = $acceptedFileInput;
            $data['dataPrivateId'] = $privateId;

            return view('file/create-file', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function detailsFolder(int $num, $validator = null)
    {
        try {
            $data['title'] = 'View Folder';

            $fileImplModel = new FileImplModel();

            $file = $fileImplModel->retrieve($num);
            if (is_null($file))
                return view('null_error', $data);

            $countFiles = $fileImplModel->countFiles($num);
            $sumFiles = $fileImplModel->sumFileSize($num);
            $folderFiles = $fileImplModel->listFolderFile($num);

            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/rename_modal.js"></script>' .
                '<script src="/assets/js/custom/info_modal.js"></script>';
            $data['validation'] = $validator;
            $data['data'] = $file;
            $data['dataCountFiles'] = $countFiles;
            $data['dataSumFiles'] = $sumFiles;
            $data['dataFiles'] = $folderFiles;

            return view('file_manager/folder/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function editFolder(string $privateId, $validator = null)
    {
        try {
            $data['title'] = 'Update Folder';

            $fileImplModel = new FileImplModel();

            $file = $fileImplModel->retrieveFolder($privateId);
            if (is_null($file))
                return view('null_error', $data);

            $data['validation'] = $validator;
            $data['data'] = $file;
            //$data['fileTypeEnum'] = FileType::getAll();

            return view('file/update-folder', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function delete(string $privateId)
    {
        try {
            $fileImplModel = new FileImplModel();

            $result = null;
            $file = $fileImplModel->retrievePrivate($privateId);
            if ($file->isDirectory) {
                $result = $fileImplModel->deleteFolder($file->id, $file->path);
            } else {
                $result = $fileImplModel->deleteFile($file->id);
            }


            if ($result === true) {
                if ($file->isDirectory) {
                    FileLibrary::deleteDirectory($file->path);
                    return redirect()->back()->with('success', 'Folder deleted successfully!');
                } else {
                    FileLibrary::deleteFile($file->path);
                    return redirect()->back()->with('success', 'File deleted successfully!');
                }
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Files in folder is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting folder!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function favourite(string $privateId)
    {
        try {
            $fileImplModel = new FileImplModel();

            $file = $fileImplModel->retrievePrivate($privateId);

            if ($fileImplModel->favourite($file->id)) {
                $check = $fileImplModel->retrievePrivate($privateId);
                if ($check->isFavourite)
                    return redirect()->back()->with('success', 'Added to favourite successfully!');
                else
                    return redirect()->back()->with('success', 'Removed from favourite successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops error when adding or removing favourite!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }

    public function trash(string $privateId)
    {
        try {
            $fileImplModel = new FileImplModel();

            $file = $fileImplModel->retrievePrivate($privateId);
            $data = array();
            if ($file->isTrash) {
                $data = array_merge(
                    $data,
                    array(
                        'FileIsTrash' => false,
                        'FilePath' => $file->parentPath . DIRECTORY_SEPARATOR . $file->name
                    )
                );
            } else {
                $data = array_merge(
                    $data,
                    array(
                        'FileIsTrash' => true,
                        'FilePath' => null
                    )
                );
            }

            if ($fileImplModel->trash($file->id, $data)) {
                $check = $fileImplModel->retrievePrivate($privateId);
                if ($check->isTrash)
                    return redirect()->back()->with('success', 'Added to trash successfully!');
                else
                    return redirect()->back()->with('success', 'Removed from trash successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops error when adding or removing from trash!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }

    public function deleteFile(string $privateId)
    {
        try {
            $fileImplModel = new FileImplModel();

            $file = $fileImplModel->retrievePrivate($privateId);
            $result = $fileImplModel->deleteFile($file->id);

            if ($result === true) {
                FileLibrary::deleteFile($file->path);
                return redirect()->back()->with('success', 'File deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'File is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting file!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function downloadFile(string $privateId)
    {
        try {
            $fileImplModel = new FileImplModel();

            $file = $fileImplModel->retrievePrivate($privateId);

            return $this->response->download($file->path, null);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeFolder(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldName, $this->fieldDescription);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileImplModel = new FileImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $employeeId = session()->get('employeeId');

                // Insert into file
                $file = $fileImplModel->retrievePrivate($privateId);
                $folder = $file->path . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileName' => $name,
                    'FilePublicId' => $privateId,
                    'FileIsDirectory' => true,
                    'FileParentPath' => $file->path,
                    'FileDescription' => $description,
                    'FileIsFavourite' => false,
                    'FileIsTrash' => false,
                    'FilePath' => $folder,
                    'CreatedId' => $employeeId,
                ];

                $result = $fileImplModel->saveFolder($data);
                if ($result === true) {
                    FileLibrary::createFolder($folder);
                    return redirect()->back()->with('success', 'Folder added successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding folder!');

            } else
                return $this->createFolder($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeFile(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldFiles);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileImplModel = new FileImplModel();

                $files = $this->request->getFileMultiple('files');
                $privateId = $this->request->getPost('privateId');
                $employeeId = session()->get('employeeId');

                // Insert into fileFile
                $file = $fileImplModel->retrievePrivate($privateId);
                $path = $file->path;
                $sumAllFileSize = $fileImplModel->sumAllFileSize();
                $datas = array();
                $totalSize = $sumAllFileSize;
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $fileName = $file->getClientName();
                        $fileMimeType = $file->getMimeType();
                        $fileSize = $file->getSize();
                        $fileExtension = $file->guessExtension();
                        $totalSize = $totalSize + $fileSize;
                        $lastModified = $file->getMTime();

                        $fileArray = [
                            'FilePublicId' => $privateId,
                            'FileIsDirectory' => false,
                            'FilePath' => $path . DIRECTORY_SEPARATOR . $fileName,
                            'FileUrlPath' => base_url($path . DIRECTORY_SEPARATOR . $fileName),
                            'FileParentPath' => $path,
                            'FileName' => $fileName,
                            'FileSize' => $fileSize,
                            'FileIsFavourite' => false,
                            'FileIsTrash' => false,
                            'FileMimeType' => $fileMimeType,
                            'FileExtension' => $fileExtension,
                            'FileLastModified' => $lastModified,
                            'CreatedId' => $employeeId,
                        ];
                        array_push($datas, $fileArray);
                    }
                }

                // Update into file
                $folder = [
                    'ModifiedId' => $employeeId,
                ];

                if ($totalSize >= $this->maxFileSize)
                    return redirect()->back()->with('fail', 'Max file size reached! ' . FileLibrary::formatBytes($this->maxFileSize));

                $result = $fileImplModel->saveFile($datas);
                if ($result === true) {
                    FileLibrary::moveFiles($files, $path);
                    return redirect()->back()->with('success', 'File added successfully!');
                } else if ($result === 1644)
                    return redirect()->back()->with('fail', 'File Name already exist in this folder!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding file!');

            } else
                return $this->createFile($privateId, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function updateFolder(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldName, $this->fieldDescription);
            $validated = $this->validate($fieldValidation);


            if ($validated) {
                $fileImplModel = new FileImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $employeeId = session()->get('employeeId');


                // Update into file 
                $file = $fileImplModel->retrieveFolder($privateId);
                if (is_null($file))
                    return view('null_error', ['title' => 'Update Folder']);


                $folder = $file->parentPath . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileName' => $name,
                    'FileDescription' => $description,
                    'FilePath' => $folder,
                    'ModifiedId' => $employeeId,
                ];

                $childFiles = array();
                $files = $fileImplModel->retrievePaths($privateId);
                foreach ($files as $key => $value) {
                    $urlPath = str_replace($file->path, $folder, $value->urlPath);
                    $path = str_replace($file->path, $folder, $value->path);

                    $childFile['FileUrlPath'] = ($value->isDirectory) ? null : $urlPath;
                    $childFile['FilePath'] = $path;
                    $childFile['FileParentPath'] = $folder;
                    $childFiles[$value->id] = $childFile;
                }

                $result = $fileImplModel->updateFolder($file->id, $data, $childFiles);
                if ($result === true) {
                    FileLibrary::rename($file->path, $folder);
                    return redirect()->back()->with('success', 'Folder updated successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating folder!');

            } else
                return $this->editFolder($privateId, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function renameFile(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldFileName);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileImplModel = new FileImplModel();

                $name = $this->request->getPost('name');
                $employeeId = session()->get('employeeId');

                $file = $fileImplModel->retrievePrivate($privateId);

                // Rename file 
                $newPath = $file->parentPath . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileName' => $name,
                    'FilePath' => $newPath,
                    'FileExtension' => pathinfo($name, PATHINFO_EXTENSION),
                    'ModifiedId' => $employeeId,
                ];

                $result = $fileImplModel->renameFile($file->id, $data);
                if ($result === true) {
                    FileLibrary::rename($file->path, $newPath);
                    return redirect()->back()->with('success', 'File renamed successfully!');
                } else if ($result === 1644)
                    return redirect()->back()->with('fail', 'File Name already exist in this folder!');
                else
                    return redirect()->back()->with('fail', 'An error occur when renaming file!');
            } else
                return redirect()->back()->with('fail', 'File name not valid');


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    private function breadCrumb(FileImplModel $fileImplModel, string $privateId, array $breadCrumbArray)
    {
        // Get selected
        $file = $fileImplModel->retrievePrivate($privateId);

        // Breadcrumb array
        if ($privateId != $fileImplModel->getFileManagerPrivateId()) {
            $filePathArray = array();
            $eachFilePathArrays = array();
            foreach (explode('/', $file->path) as $key => $value) {
                array_push($eachFilePathArrays, $value);
                $filePathArray[implode(DIRECTORY_SEPARATOR, $eachFilePathArrays)] = $value;
            }
            array_shift($filePathArray);
            array_shift($filePathArray);
            $lastFilePathValue = array_pop($filePathArray);
            foreach ($filePathArray as $key => $value) {
                $filePrivateId = $fileImplModel->getPrivateId($key);
                $breadCrumbArray = array_merge($breadCrumbArray, array($filePrivateId => $value));
            }
            $breadCrumbArray = array_merge($breadCrumbArray, array($lastFilePathValue));
        }

        return $breadCrumbArray;
    }





}
