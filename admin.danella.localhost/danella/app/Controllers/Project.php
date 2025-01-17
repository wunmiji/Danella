<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\ProjectImplModel;
use App\ImplModel\ServiceImplModel;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\SecurityLibrary;

use Cocur\Slugify\Slugify;



class Project extends BaseController
{

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Project name is required',
                'max_length' => 'Max length for name is 250'
            ]
        ]
    ];

    protected $fieldClient = [
        'client' => [
            'rules' => 'required|max_length[70]',
            'errors' => [
                'required' => 'Project client is required',
                'max_length' => 'Max length for client is 70'
            ]
        ]
    ];

    protected $fieldLocation = [
        'location' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'Project location is required',
                'max_length' => 'Max length for location is 50'
            ]
        ]
    ];

    protected $fieldDate = [
        'date' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Project Date is required'
            ]
        ]
    ];

    protected $fieldText = [
        'text' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Project text is required',
            ]
        ]
    ];

    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        try {
            $projectImplModel = new ProjectImplModel();

            $queryPage = $this->request->getVar('page');
            $queryLimit = $this->request->getVar('limit');
            $pagination = $projectImplModel->pagination($queryPage ?? 1, $queryLimit ?? reset($this->paginationLimitArray));

            $data['title'] = 'Projects';
            $data['js_files'] = '<script src="/assets/js/custom/search_table.js"></script>';
            $data['data'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'projects?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('projects/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function create($validator = null)
    {
        try {
            $serviceImplModel = new ServiceImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            // Get All services
            $services = json_decode($serviceImplModel->listNameJson());

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();


            $data['title'] = 'New Project';
            $data['validation'] = $validator;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">' .
                '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">' . 
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/library/flatpickr.js"></script>' .
                '<script src="/assets/js/library/quill.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/project.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['services'] = $services;
            $data['folders'] = $folders;

            return view('projects/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Project';

            $projectImplModel = new ProjectImplModel();
            $serviceImplModel = new ServiceImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            $project = $projectImplModel->retrieve($num);
            if (is_null($project))
                return view('null_error', $data);

            // Get All project_service_ids
            $projectServiceIds = array();
            foreach ($project->services as $value) {
                $projectServiceIds[$value->id] = $value->serviceId;
            }

            // Get All project_gallary
            $projectGallary = json_encode($project->gallary);

            // Get All services
            $services = json_decode($serviceImplModel->listNameJson());

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            $data['validation'] = $validator;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">' .
                '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">' . 
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/library/flatpickr.js"></script>' .
                '<script src="/assets/js/library/quill.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/project.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['data'] = $project;
            $data['dataText'] = $project->text;
            $data['dataImage'] = $project->image;
            $data['dataServices'] = $projectServiceIds;
            $data['dataGallary'] = $projectGallary;
            $data['services'] = $services;
            $data['folders'] = $folders;


            return view('projects/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Project';

            $projectImplModel = new ProjectImplModel();

            $project = $projectImplModel->retrieve($num);
            if (is_null($project))
                return view('null_error', $data);

            $data['data'] = $project;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">';
            $data['js_files'] = '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['dataText'] = $project->text;
            $data['dataImage'] = $project->image;
            $data['dataServices'] = $project->services;
            $data['dataGallary'] = $project->gallary;
            $data['dataFiles'] = $project->files;

            return view('projects/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $projectImplModel = new ProjectImplModel();

            if ($projectImplModel->delete($num)) {
                return redirect()->route('projects')->with('success', 'Project deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops project was not deleted!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function status(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $projectImplModel = new ProjectImplModel();

            if ($projectImplModel->status($num, session()->get('employeeId'))) {
                return redirect()->back()->with('success', 'Project status changed successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops project status was not changed!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function files(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Project Files';

            $projectImplModel = new ProjectImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            $project = $projectImplModel->retrieve($num);
            if (is_null($project))
                return view('null_error', $data);

            // Get All folder
            $folders = $fileManagerImplModel->ListPrivateFoldersWithFiles();

            // Get All project_files
            $projectFiles = json_encode($project->files);

            $data['data'] = $project;
            $data['js_files'] = '<script src="/assets/js/custom/private_files_modal.js"></script>';
            $data['dataFiles'] = $projectFiles;
            $data['folders'] = $folders;


            return view('projects/files', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function store()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldName,
                $this->fieldClient,
                $this->fieldLocation,
                $this->fieldDate
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $projectImplModel = new ProjectImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $client = $this->request->getPost('client');
                $location = $this->request->getPost('location');
                $date = $this->request->getPost('date');
                $text = $this->request->getPost('text');
                $services = $this->request->getPost('services') ?? array();
                $file = $this->request->getPost('file');
                $files = $this->request->getPost('files') ?? array();
                $employeeId = session()->get('employeeId');


                // Insert into project
                $data = [
                    'ProjectName' => $name,
                    'ProjectSlug' => $slugify->slugify($name),
                    'ProjectStatus' => false,
                    'ProjectLocation' => $location,
                    'ProjectDate' => $date,
                    'ProjectClient' => $client,
                    'CreatedId' => $employeeId,
                ];

                // Insert into projectFile
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'ProjectImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Insert into projectText
                $dataText = [
                    'ProjectText' => $text,
                ];

                // Insert into projectService
                $dataServices = array();
                foreach ($services as $service) {
                    $serviceArray = [
                        'ProjectServiceServiceFk' => $service
                    ];
                    array_push($dataServices, $serviceArray);
                }

                // Insert into projectGallary
                $dataGallary = array();
                foreach ($files as $file) {
                    $jsonFile = json_decode($file);
                    if (is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                        return redirect()->back()->with('fail', 'Featured Image not valid!');
                    $gallaryArray = [
                        'ProjectGallaryFileManagerFileFk' => $jsonFile->fileId,
                    ];
                    array_push($dataGallary, $gallaryArray);
                }

                $result = $projectImplModel->save($data, $dataImage, $dataText, $dataServices, $dataGallary);
                if ($result === true)
                    return redirect()->back()->with('success', 'Project added successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding project!');

            } else
                return $this->create($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function update(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge(
                $this->fieldName,
                $this->fieldClient,
                $this->fieldLocation,
                $this->fieldDate
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $projectImplModel = new ProjectImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $client = $this->request->getPost('client');
                $location = $this->request->getPost('location');
                $date = $this->request->getPost('date');
                $text = $this->request->getPost('text');
                $services = $this->request->getPost('services') ?? array();
                $file = $this->request->getPost('file');
                $files = $this->request->getPost('files') ?? array();
                $employeeId = session()->get('employeeId');

                // Update into project
                $data = [
                    'ProjectName' => $name,
                    'ProjectSlug' => $slugify->slugify($name),
                    'ProjectLocation' => $location,
                    'ProjectDate' => $date,
                    'ProjectClient' => $client,
                    'ModifiedId' => $employeeId,
                ];

                // Update into projectImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'ProjectId' => $num,
                    'ProjectImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Update into projectText
                $dataText = [
                    'ProjectId' => $num,
                    'ProjectText' => $text,
                ];

                // Update into projectService
                $dataServices = array();
                foreach ($services as $service) {
                    $jsonService = json_decode($service);
                    $serviceArray = [
                        'ProjectServiceId' => $jsonService->id,
                        'ProjectServiceServiceFk' => $jsonService->serviceId,
                        'ProjectServiceProjectFk' => $num
                    ];
                    array_push($dataServices, $serviceArray);
                }

                // Update into projectGallary
                $dataGallary = array();
                foreach ($files as $file) {
                    $jsonFile = json_decode($file);
                    if (is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                        return redirect()->back()->with('fail', 'Featured Image not valid!');
                    $gallaryArray = [
                        'ProjectGallaryId' => $jsonFile->id ?? null,
                        'ProjectGallaryProjectFk' => $num,
                        'ProjectGallaryFileManagerFileFk' => $jsonFile->fileId,
                    ];
                    array_push($dataGallary, $gallaryArray);
                }

                $result = $projectImplModel->update($num, $data, $dataImage, $dataText, $dataServices, $dataGallary);
                if ($result === true)
                    return redirect()->back()->with('success', 'Project updated successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating project!');


            } else
                return $this->edit($num, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function updateFiles(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $projectImplModel = new ProjectImplModel();
            $fileManagerImplModel = new FileManagerImplModel();


            $files = $this->request->getPost('files') ?? array();
            $employeeId = session()->get('employeeId');

            // Update into project
            $data = [
                'ModifiedId' => $employeeId,
            ];

            // Update into projectFiles
            $dataFiles = array();
            foreach ($files as $file) {
                $jsonFile = json_decode($file);
                if (is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'File not valid!');
                $filesArray = [
                    'ProjectFilesId' => $jsonFile->id ?? null,
                    'ProjectFilesProjectFk' => $num,
                    'ProjectFilesFileManagerFileFk' => $jsonFile->fileId,
                ];
                array_push($dataFiles, $filesArray);
            }

            $result = $projectImplModel->updateFiles($num, $data, $dataFiles);
            if ($result === true)
                return redirect()->back()->with('success', 'Project files updated successfully!');
            else
                return redirect()->back()->with('fail', 'An error occur when updating project files!');


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}