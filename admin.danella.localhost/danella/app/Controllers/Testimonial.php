<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\TestimonialImplModel;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\SecurityLibrary;


class Testimonial extends BaseController
{

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 30'
            ]
        ]
    ];

    protected $fieldPosition = [
        'position' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'Position is required',
                'max_length' => 'Max length for position is 30'
            ]
        ]
    ];

    protected $fieldNote = [
        'note' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Note is required',
                'max_length' => 'Max length for note is 250'
            ]
        ]
    ];

    protected $fieldFile = [
        'file' => [
            'rules' => 'uploaded[file]|is_image[file]',
            'errors' => [
                'uploaded' => 'Image is required',
                'is_image' => 'File is not image',
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
            $testimonialImplModel = new TestimonialImplModel();

            $queryPage = $this->request->getVar('page');
            $queryLimit = $this->request->getVar('limit');
            $pagination = $testimonialImplModel->pagination($queryPage ?? 1, $queryLimit ?? reset($this->paginationLimitArray));

            $data['title'] = 'Testimonials';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['data'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'testimonials?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('testimonials/index', $data);
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

            $data['title'] = 'New Testimonial';
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/custom/files_modal.js"></script>';
            $data['validation'] = $validator;
            $data['folders'] = $folders;

            return view('testimonials/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Testimonial';

            $testimonialImplModel = new TestimonialImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            $testimonial = $testimonialImplModel->retrieve($num);
            if (is_null($testimonial))
                return view('null_error', $data);

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            $data['validation'] = $validator;
            $data['css_files'] =  '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/custom/files_modal.js"></script>';
            $data['data'] = $testimonial;
            $data['dataImage'] = $testimonial->image;
            $data['folders'] = $folders;

            return view('testimonials/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Testimonial';

            $testimonialImplModel = new TestimonialImplModel();

            $testimonial = $testimonialImplModel->retrieve($num);
            if (is_null($testimonial))
                return view('null_error', $data);

            $data['js_files'] = '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['data'] = $testimonial;
            $data['dataImage'] = $testimonial->image;

            return view('testimonials/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


    public function status(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $testimonialImplModel = new TestimonialImplModel();

            if ($testimonialImplModel->status($num, session()->get('employeeId'))) {
                return redirect()->back()->with('success', 'Testimonial status changed successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops testimonial status was not changed!');
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
            $testimonialImplModel = new TestimonialImplModel();

            if ($testimonialImplModel->delete($num)) {
                return redirect()->route('testimonials')->with('success', 'Testimonial deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops testimonial was not deleted!');
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
                $this->fieldPosition,
                $this->fieldNote
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $testimonialImplModel = new TestimonialImplModel();
                $fileManagerImplModel = new FileManagerImplModel();

                $name = $this->request->getPost('name');
                $position = $this->request->getPost('position');
                $note = $this->request->getPost('note');
                $file = $this->request->getPost('file');
                $employeeId = session()->get('employeeId');

                // Insert into testimonial
                $data = [
                    'TestimonialName' => $name,
                    'TestimonialNote' => $note,
                    'TestimonialStatus' => false,
                    'TestimonialPosition' => $position,
                    'CreatedId' => $employeeId,
                ];

                // Insert into testimonialImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'TestimonialImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                if ($testimonialImplModel->save($data, $dataImage)) {
                    return redirect()->back()->with('success', 'Testimonial added successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when adding testimonial!');
                }

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
                $this->fieldPosition,
                $this->fieldNote
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $testimonialImplModel = new TestimonialImplModel();
                $fileManagerImplModel = new FileManagerImplModel();

                $name = $this->request->getPost('name');
                $position = $this->request->getPost('position');
                $note = $this->request->getPost('note');
                $file = $this->request->getPost('file');
                $employeeId = session()->get('employeeId');

                // Update into testimonial
                $data = [
                    'TestimonialName' => $name,
                    'TestimonialNote' => $note,
                    'TestimonialPosition' => $position,
                    'ModifiedId' => $employeeId,
                ];

                // Update into testimonialImage
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'TestimonialId' => $num,
                    'TestimonialImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                if ($testimonialImplModel->update($num, $data, $dataImage)) {
                    return redirect()->back()->with('success', 'Testimonial updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating testimonial!');
                }

            } else
                return $this->edit($num, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}