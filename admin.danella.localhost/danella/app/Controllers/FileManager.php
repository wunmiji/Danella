<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\FileLibrary;
use App\Enums\FileType;
use App\Libraries\SecurityLibrary;

use Cocur\Slugify\Slugify;

class FileManager extends BaseController
{
    protected $maxFileManagerSize; // 5368709120 (5gb)

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
        $this->maxFileManagerSize = disk_total_space("/");
    }

    public function index()
    {
        try {
            $fileManagerImplModel = new FileManagerImplModel();

            $sumAllFileSize = $fileManagerImplModel->sumAllFileSize();
            $freeSpace = $this->maxFileManagerSize - $sumAllFileSize;

            $queryPage = $this->request->getVar('page');
            $queryLimit = $this->request->getVar('limit');
            $pagination = $fileManagerImplModel->pagination($queryPage ?? 1, $queryLimit ?? reset($this->paginationLimitArray));

            $data['title'] = 'File Manager';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['data'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'file-manager?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;
            $data['usedSpaceFormat'] = FileLibrary::formatBytes($sumAllFileSize);
            $data['totalSpaceFormat'] = FileLibrary::formatBytes($this->maxFileManagerSize);
            $data['freeSpaceFormat'] = FileLibrary::formatBytes($freeSpace);

            return view('file_manager/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function createFolder($validator = null)
    {
        try {
            $data['title'] = 'New Folder';
            $data['validation'] = $validator;
            $data['fileTypeEnum'] = FileType::getAll();

            return view('file_manager/folder/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function createFile(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'New File';

            $fileManagerImplModel = new FileManagerImplModel();

            $fileManager = $fileManagerImplModel->retrieveFolder($num);
            if (is_null($fileManager))
                return view('null_error', $data);

            $acceptedFileInput = '';
            if ($fileManager->type === FileType::PUBLIC->name) $acceptedFileInput = 'video/*, image/*';
            if ($fileManager->type === FileType::PRIVATE->name) $acceptedFileInput = 'application/pdf, application/msword, application/zip, text/*, audio/*, video/*, image/*';
            
            $data['dataNum'] = $num;
            $data['js_files'] = '<script src="/assets/js/custom/file_manager.js"></script>';
            $data['validation'] = $validator;
            $data['acceptedFileInput'] = $acceptedFileInput;

            return view('file_manager/file/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function detailsFolder(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Folder';

            $fileManagerImplModel = new FileManagerImplModel();

            $fileManager = $fileManagerImplModel->retrieve($num);
            if (is_null($fileManager))
                return view('null_error', $data);

            $countFiles = $fileManagerImplModel->countFiles($num);
            $sumFiles = $fileManagerImplModel->sumFileSize($num);
            $folderFiles = $fileManagerImplModel->listFolderFile($num);

            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/rename_modal.js"></script>' .
                '<script src="/assets/js/custom/info_modal.js"></script>';
            $data['validation'] = $validator;
            $data['data'] = $fileManager;
            $data['dataCountFiles'] = $countFiles;
            $data['dataSumFiles'] = $sumFiles;
            $data['dataFiles'] = $folderFiles;

            return view('file_manager/folder/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function editFolder(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Folder';

            $fileManagerImplModel = new FileManagerImplModel();

            $fileManager = $fileManagerImplModel->retrieve($num);
            if (is_null($fileManager))
                return view('null_error', $data);

            $data['validation'] = $validator;
            $data['data'] = $fileManager;
            $data['fileTypeEnum'] = FileType::getAll();

            return view('file_manager/folder/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function deleteFolder(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fileManagerImplModel = new FileManagerImplModel();

            $path = $fileManagerImplModel->folderPath($num);
            $result = $fileManagerImplModel->delete($num);
            if ($result === true) {
                FileLibrary::deleteDirectory($path);
                return redirect()->route('file-manager')->with('success', 'Folder deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Files in folder is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting folder!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function deleteFile(string $cipherFolder, string $cipherFile)
    {

        try {
            $folderNum = SecurityLibrary::decryptUrlId($cipherFolder);
            $fileNum = SecurityLibrary::decryptUrlId($cipherFile);
            $fileManagerImplModel = new FileManagerImplModel();

            $file = $fileManagerImplModel->filePath($fileNum);
            // Update into fileManager
            $folder = [
                'ModifiedId' => session()->get('employeeId'),
            ];
            $result = $fileManagerImplModel->deleteFile($fileNum, $folderNum, $folder);

            if ($result === true) {
                FileLibrary::deleteFile($file->filePath);
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

    public function downloadFile(string $cipherFolder, string $cipherFile)
    {
        try {
            $folderNum = SecurityLibrary::decryptUrlId($cipherFolder);
            $fileNum = SecurityLibrary::decryptUrlId($cipherFile);
            $fileManagerImplModel = new FileManagerImplModel();

            $file = $fileManagerImplModel->filePath($fileNum);

            return $this->response->download($file->filePath, null);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeFolder()
    {
        try {
            $fieldValidation = array_merge($this->fieldName, $this->fieldDescription);
            $validated = $this->validate($fieldValidation);


            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $type = $this->request->getPost('type');
                $employeeId = session()->get('employeeId');

                // Insert into fileManager
                $privatePath = FileLibrary::$privateDir . $slugify->slugify($name, '_');
                $publicPath = FileLibrary::$publicDir . $slugify->slugify($name, '_');
                $data = [
                    'FileManagerName' => $name,
                    'FileManagerType' => $type,
                    'FileManagerDescription' => $description,
                    'FileManagerUrlPath' => base_url(($type == FileType::PRIVATE ->name) ? $privatePath : $publicPath),
                    'FileManagerPath' => ($type == FileType::PRIVATE ->name) ? $privatePath : $publicPath,
                    'CreatedId' => $employeeId,
                ];

                $result = $fileManagerImplModel->saveFolder($data);
                if ($result === true) {
                    FileLibrary::createFolder(($type == FileType::PRIVATE ->name) ? $privatePath : $publicPath);
                    return redirect()->back()->with('success', 'Folder added successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding fileManager!');

            } else
                return $this->createFolder($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeFile(string $cipherFolder)
    {
        // Mysql Trigger is used to check for uniqueness of filename in folder
        try {
            $folderNum = SecurityLibrary::decryptUrlId($cipherFolder);
            $fieldValidation = array_merge($this->fieldFiles);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();

                $files = $this->request->getFileMultiple('files');
                $employeeId = session()->get('employeeId');

                // Insert into fileManagerFile
                $path = $fileManagerImplModel->folderPath($folderNum);
                $sumAllFileSize = $fileManagerImplModel->sumAllFileSize();
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
                            'FileManagerFileFileManagerFk' => $folderNum,
                            'FileManagerFileName' => $fileName,
                            'FileManagerFileSize' => $fileSize,
                            'FileManagerFileMimeType' => $fileMimeType,
                            'FileManagerFileExtension' => $fileExtension,
                            'FileManagerFileLastModified' => $lastModified,
                            'CreatedId' => $employeeId,
                        ];
                        array_push($datas, $fileArray);
                    }
                }

                // Update into fileManager
                $folder = [
                    'ModifiedId' => $employeeId,
                ];

                if ($totalSize >= $this->maxFileManagerSize)
                    return redirect()->back()->with('fail', 'Max file size reached! ' . FileLibrary::formatBytes($this->maxFileManagerSize));

                $result = $fileManagerImplModel->saveFile($folderNum, $folder, $datas);
                if ($result === true) {
                    FileLibrary::moveFiles($files, $path);
                    return redirect()->back()->with('success', 'File added successfully!');
                } else if ($result === 1644)
                    return redirect()->back()->with('fail', 'File Name already exist in this folder!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding fileManager!');

            } else
                return $this->createFile($folderNum, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function updateFolder(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge($this->fieldName, $this->fieldDescription);
            $validated = $this->validate($fieldValidation);


            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $employeeId = session()->get('employeeId');


                // Update into fileManager 
                $oldPath = null;
                $type = null;
                $fileManager = $fileManagerImplModel->retrieve($num);
                if (is_null($fileManager))
                    return view('null_error', ['title' => 'Update Folder']);
                else {
                    $oldPath = $fileManager->path;
                    $type = $fileManager->type;
                }

                $privatePath = FileLibrary::$privateDir . $slugify->slugify($name, '_');
                $publicPath = FileLibrary::$publicDir . $slugify->slugify($name, '_');
                $data = [
                    'FileManagerName' => $name,
                    'FileManagerDescription' => $description,
                    'FileManagerUrlPath' => base_url(($type == FileType::PRIVATE ->name) ? $privatePath : $publicPath),
                    'FileManagerPath' => ($type == FileType::PRIVATE ->name) ? $privatePath : $publicPath,
                    'ModifiedId' => $employeeId,
                ];

                $result = $fileManagerImplModel->updateFolder($num, $data);
                if ($result === true) {
                    if ($type == FileType::PRIVATE ->name)
                        FileLibrary::rename($oldPath, $privatePath);
                    else FileLibrary::rename($oldPath, $publicPath);
                    return redirect()->back()->with('success', 'Folder updated successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating fileManager!');

            } else
                return $this->editFolder($num, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function renameFile(string $cipherFolder, string $cipherFile)
    {
        // Mysql Trigger is used to check for uniqueness of filename in folder
        try {
            $folderNum = SecurityLibrary::decryptUrlId($cipherFolder);
            $fileNum = SecurityLibrary::decryptUrlId($cipherFile);
            $fieldValidation = array_merge($this->fieldFileName);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();

                $name = $this->request->getPost('name');
                $employeeId = session()->get('employeeId');

                $fileManagerFile = $fileManagerImplModel->filePath($fileNum);

                // Rename file 
                $newPath = $fileManagerFile->path . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileManagerFileName' => $name,
                    'FileManagerFileExtension' => pathinfo($name, PATHINFO_EXTENSION),
                    'ModifiedId' => $employeeId,
                ];

                // Update into fileManager
                $folder = [
                    'ModifiedId' => $employeeId,
                ];

                $result = $fileManagerImplModel->renameFile($fileNum, $folderNum, $folder, $data);
                if ($result === true) {
                    FileLibrary::rename($fileManagerFile->filePath, $newPath);
                    return redirect()->back()->with('success', 'File renamed successfully!');
                } else if ($result === 1644)
                    return redirect()->back()->with('fail', 'File Name already exist in this folder!');
                else
                    return redirect()->back()->with('fail', 'An error occur when renaming file!');
            } else
                return redirect()->back()->with('fail', 'File name not valid');


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }





}
