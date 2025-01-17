<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\BlogImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\ServiceImplModel;
use App\Libraries\SecurityLibrary;

use Cocur\Slugify\Slugify;
use PhpScience\TextRank\Tool\StopWords\English;
use PhpScience\TextRank\TextRankFacade;



class Blog extends BaseController
{

    protected $fieldTitle = [
        'title' => [
            'rules' => 'required|max_length[120]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for title is 120'
            ]
        ]
    ];

    protected $fieldSummary = [
        'summary' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Summary is required',
                'max_length' => 'Max length for summary is 250'
            ]
        ]
    ];

    protected $fieldText = [
        'text' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Text is required'
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
            $blogImplModel = new BlogImplModel();

            $queryPage = $this->request->getVar('page');
            $queryLimit = $this->request->getVar('limit');
            $pagination = $blogImplModel->pagination($queryPage ?? 1, $queryLimit ?? reset($this->paginationLimitArray));

            $data['title'] = 'Blog';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['data'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'blog?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('blog/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }

    public function create($validator = null)
    {
        try {
            $serviceImplModel = new ServiceImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            // Get All services
            $services = json_decode($serviceImplModel->listNameJson());

            $data['title'] = 'New Blog';
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/library/quill.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['validation'] = $validator;
            $data['services'] = $services;
            $data['folders'] = $folders;

            return view('blog/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Blog';

            $blogImplModel = new BlogImplModel();
            $serviceImplModel = new ServiceImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            $blog = $blogImplModel->retrieve($num);
            if (is_null($blog))
                return view('null_error', $data);

            // Get All blog_category_ids
            $blogCategoryIds = array();
            foreach ($blog->categories as $value) {
                $blogCategoryIds[$value->id] = $value->categoryId;
            }

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            // Get All services
            $services = json_decode($serviceImplModel->listNameJson());

            $data['validation'] = $validator;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/library/quill.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['data'] = $blog;
            $data['dataImage'] = $blog->image;
            $data['dataText'] = $blog->text;
            $data['dataCategories'] = $blogCategoryIds;
            $data['folders'] = $folders;
            $data['services'] = $services;

            return view('blog/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Blog';

            $blogImplModel = new BlogImplModel();

            $blog = $blogImplModel->retrieve($num);
            if (is_null($blog))
                return view('null_error', $data);

            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">';
            $data['js_files'] = '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['data'] = $blog;
            $data['dataText'] = $blog->text;
            $data['dataImage'] = $blog->image;
            $data['dataAuthor'] = $blog->author;
            $data['dataCategories'] = $blog->categories;

            return view('blog/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function status(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $blogImplModel = new BlogImplModel();

            if ($blogImplModel->status($num, session()->get('employeeId'))) {
                return redirect()->back()->with('success', 'Blog status changed successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops blog status was not changed!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $blogImplModel = new BlogImplModel();

            if ($blogImplModel->delete($num)) {
                return redirect()->route('blog')->with('success', 'Blog deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops blog was not deleted!');
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
                $this->fieldTitle,
                $this->fieldSummary,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $blogImplModel = new BlogImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $title = $this->request->getPost('title');
                $summary = $this->request->getPost('summary');
                $text = $this->request->getPost('text');
                $services = $this->request->getPost('services') ?? array();
                $file = $this->request->getPost('file');
                $employeeId = session()->get('employeeId');

                // Insert into blog
                $data = [
                    'BlogTitle' => $title,
                    'BlogSlug' => $slugify->slugify($title),
                    'BlogSummary' => $summary,
                    'BlogStatus' => false,
                    'CreatedId' => $employeeId,
                ];

                // Insert into blogImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'BlogImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Insert into blogText
                $dataText = [
                    'BlogText' => $text,
                ];

                // Insert into blogAuthor
                $dataAuthor = [
                    'BlogAuthorEmployeeFk' => $employeeId,
                ];

                // Insert into blogCategory
                $dataCategories = array();
                foreach ($services as $service) {
                    $serviceArray = [
                        'BlogCategoryServiceFk' => $service
                    ];
                    array_push($dataCategories, $serviceArray);
                }

                $result = $blogImplModel->save($data, $dataImage, $dataText, $dataAuthor, $dataCategories);
                if ($result === true)
                    return redirect()->back()->with('success', 'Blog added successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Title already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding blog!');

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
                $this->fieldTitle,
                $this->fieldSummary,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $blogImplModel = new BlogImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $title = $this->request->getPost('title');
                $summary = $this->request->getPost('summary');
                $text = $this->request->getPost('text');
                $services = $this->request->getPost('services') ?? array();
                $file = $this->request->getPost('file');
                $employeeId = session()->get('employeeId');

                // Update into blog
                $data = [
                    'BlogTitle' => $title,
                    'BlogSlug' => $slugify->slugify($title),
                    'BlogSummary' => $summary,
                    'ModifiedId' => $employeeId,
                ];

                // Update into blogImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'BlogId' => $num,
                    'BlogImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Update into blogText
                $dataText = [
                    'BlogId' => $num,
                    'BlogText' => $text,
                ];

                // Update into blogAuthor
                $dataAuthor = [
                    'BlogId' => $num,
                    'BlogAuthorEmployeeFk' => $employeeId,
                ];

                // Update into blogCategory
                $dataCategories = array();
                foreach ($services as $service) {
                    $jsonService = json_decode($service);
                    $serviceArray = [
                        'BlogCategoryId' => $jsonService->id,
                        'BlogCategoryServiceFk' => $jsonService->serviceId,
                        'BlogCategoryBlogFk' => $num
                    ];
                    array_push($dataCategories, $serviceArray);
                }

                $result = $blogImplModel->update($num, $data, $dataImage, $dataText, $dataAuthor, $dataCategories);
                if ($result === true)
                    return redirect()->back()->with('success', 'Blog updated successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Title already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating blog!');

            } else
                return $this->edit($num, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}