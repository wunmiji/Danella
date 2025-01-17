<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\ServiceImplModel;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\SecurityLibrary;

use Cocur\Slugify\Slugify;

class Service extends BaseController
{

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 100'
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

    protected $fieldText = [
        'text' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Text is required',
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
            $serviceImplModel = new ServiceImplModel();

            $queryPage = $this->request->getVar('page');
            $queryLimit = $this->request->getVar('limit');
            $pagination = $serviceImplModel->pagination($queryPage ?? 1, $queryLimit ?? reset($this->paginationLimitArray));

            $data['title'] = 'Services';
            $data['css_files'] = '<script src="/assets/js/custom/search_table.js"></script>';
            $data['data'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'services?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('services/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function create($validator = null)
    {
        try {
            $fileManagerImplModel = new FileManagerImplModel();

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            $data['title'] = 'New Service';
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/library/quill.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>' .
                '<script src="/assets/js/custom/faq.js"></script>';
            $data['validation'] = $validator;
            $data['folders'] = $folders;

            return view('services/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Service';

            $serviceImplModel = new ServiceImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            $service = $serviceImplModel->retrieve($num);
            if (is_null($service))
                return view('null_error', $data);

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            $data['validation'] = $validator;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/library/quill.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>' .
                '<script src="/assets/js/custom/faq.js"></script>';
            $data['data'] = $service;
            $data['dataImage'] = $service->image;
            $data['dataText'] = $service->text;
            $data['dataFaqs'] = json_encode($service->faqs);
            $data['folders'] = $folders;

            return view('services/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Service';

            $serviceImplModel = new ServiceImplModel();

            $service = $serviceImplModel->retrieve($num);
            if (is_null($service))
                return view('null_error', $data);

            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">';
            $data['js_files'] = '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['data'] = $service;
            $data['dataImage'] = $service->image;
            $data['dataText'] = $service->text;
            $data['dataFaqs'] = $service->faqs;

            return view('services/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $serviceImplModel = new ServiceImplModel();

            $result = $serviceImplModel->delete($num);
            if ($result === true) {
                return redirect()->route('services')->with('success', 'Service deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Service is already used in project(s)!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting service!');
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
            $serviceImplModel = new ServiceImplModel();

            if ($serviceImplModel->status($num, session()->get('employeeId'))) {
                return redirect()->back()->with('success', 'Service status changed successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops service status was not changed!');
            }
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
                $this->fieldDescription,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $serviceImplModel = new ServiceImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $text = $this->request->getPost('text');
                $file = $this->request->getPost('file');
                $faqsHidden = $this->request->getPost('faqsHidden');
                $employeeId = session()->get('employeeId');

                // Insert into service
                $data = [
                    'ServiceName' => $name,
                    'ServiceSlug' => $slugify->slugify($name),
                    'ServiceDescription' => $description,
                    'ServiceStatus' => false,
                    'CreatedId' => $employeeId,
                ];

                // Insert into serviceImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'ServiceImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Insert into serviceText
                $dataText = [
                    'ServiceText' => $text,
                ];

                // Insert into serviceFaq
                $dataFaqs = array();
                $faqsArray = json_decode($faqsHidden);
                foreach ($faqsArray as $each) {
                    $faq = [
                        'ServiceFaqQuestion' => $each->question,
                        'ServiceFaqAnswer' => $each->answer,
                    ];
                    array_push($dataFaqs, $faq);
                }

                $result = $serviceImplModel->save($data, $dataImage, $dataText, $dataFaqs);
                if ($result === true)
                    return redirect()->back()->with('success', 'Service added successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding service!');

            } else
                return $this->create($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function update(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge(
                $this->fieldName,
                $this->fieldDescription,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $serviceImplModel = new ServiceImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $text = $this->request->getPost('text');
                $file = $this->request->getPost('file');
                $faqsHidden = $this->request->getPost('faqsHidden');
                $employeeId = session()->get('employeeId');

                // Update service
                $data = [
                    'ServiceName' => $name,
                    'ServiceSlug' => $slugify->slugify($name),
                    'ServiceDescription' => $description,
                    'ServiceText' => $text,
                    'ModifiedId' => $employeeId,
                ];

                // Update into serviceImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'ServiceId' => $num,
                    'ServiceImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Update into serviceText
                $dataText = [
                    'ServiceId' => $num,
                    'ServiceText' => $text,
                ];

                // Update into serviceFaq
                $dataFaqs = array();
                $faqsArray = json_decode($faqsHidden);
                foreach ($faqsArray as $each) {
                    $faq = [
                        'ServiceFaqId' => $each->id,
                        'ServiceFaqServiceFk' => $num,
                        'ServiceFaqQuestion' => $each->question,
                        'ServiceFaqAnswer' => $each->answer,
                    ];
                    array_push($dataFaqs, $faq);
                }

                $result = $serviceImplModel->update($num, $data, $dataImage, $dataText, $dataFaqs);
                if ($result === true)
                    return redirect()->back()->with('success', 'Service updated successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating service!');



            } else
                return $this->edit($num, $this->validator);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}