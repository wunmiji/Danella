<?php


namespace App\Controllers;

use App\Libraries\SecurityLibrary;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\EmployeeImplModel;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\PasswordLibrary;


class Employee extends BaseController
{

    protected $fieldFirstName = [
        'first_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your first name is required',
                'max_length' => 'Max length for first name is 15'
            ]
        ]
    ];

    protected $fieldLastName = [
        'last_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your last name is required',
                'max_length' => 'Max length for last name is 15'
            ]
        ],
    ];

    protected $fieldEmail = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Your email is required',
                'valid_email' => 'Email is not valid'
            ]
        ]
    ];

    protected $fieldTelephone = [
        'telephone' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your telephone number is required',
                'max_length' => 'Max length for telephone is 15'
            ]
        ]
    ];

    protected $fieldMobile = [
        'mobile' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your mobile number is required',
                'max_length' => 'Max length for mobile is 15'
            ]
        ]
    ];

    protected $fieldNewPassword = [
        'new_password' => [
            'rules' => 'required|min_length[5]|max_length[20]',
            'errors' => [
                'required' => 'Your new password is required',
                'min_length' => 'Password must be 5 characters long',
                'max_length' => 'Password cannot be longer than 20 characters'
            ]
        ]
    ];

    protected $fieldConfrimNewPassword = [
        'confrim_new_password' => [
            'rules' => 'required|min_length[5]|max_length[20]|matches[new_password]',
            'errors' => [
                'required' => 'Your confirm new password is required',
                'min_length' => 'Password must be 5 characters long',
                'max_length' => 'Password cannot be longer than 20 characters',
                'matches' => 'Your new passwords do not match'
            ]
        ]
    ];

    protected $fieldDescription = [
        'description' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Description is required',
                'max_length' => 'Max length for description is 250'
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
            $employeeImplModel = new EmployeeImplModel();

            $employeeId = session()->get('employeeId');
            $employee = $employeeImplModel->retrieve($employeeId);

            $data['title'] = 'Employee';
            $data['data'] = $employee;
            $data['dataImage'] = $employee->image;
            $data['dataContact'] = $employee->contact;

            return view('employees/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Employee';

            $employeeImplModel = new EmployeeImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            $employee = $employeeImplModel->retrieve($num);
            if (is_null($employee))
                return view('null_error', $data);
            $employeeContact = $employee->contact;

            // Get All folder
            $folders = $fileManagerImplModel->ListPublicFoldersWithFiles();

            $data['data'] = $employee;
            $data['dataImage'] = $employee->image;
            $data['dataContact'] = $employeeContact;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/custom/files_modal.js"></script>';
            $data['validation'] = $validator;
            $data['folders'] = $folders;

            return view('employees/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function editPassword(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $employeeImplModel = new EmployeeImplModel();

            $employee = $employeeImplModel->retrieve($num);

            $data['title'] = 'Update Employee';
            $data['employee_password'] = $employee->secret;
            $data['validation'] = $validator;

            return view('employees/update_password', $data);
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
                $this->fieldFirstName,
                $this->fieldLastName,
                $this->fieldEmail,
                $this->fieldTelephone,
                $this->fieldMobile,
                $this->fieldDescription
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $employeeImplModel = new EmployeeImplModel();
                $fileManagerImplModel = new FileManagerImplModel();

                $firstName = $this->request->getPost('first_name');
                $lastName = $this->request->getPost('last_name');
                $email = $this->request->getPost('email');
                $mobile = $this->request->getPost('mobile');
                $telephone = $this->request->getPost('telephone');
                $description = $this->request->getPost('description');
                $file = $this->request->getPost('file');


                // Update into employee
                $data = [
                    'EmployeeFirstName' => $firstName,
                    'EmployeeLastName' => $lastName,
                    'EmployeeDescription' => $description,
                ];

                // Update into employeeFile
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'EmployeeId' => $num,
                    'EmployeeImageFileManagerFileFk' => $jsonFile->fileId,
                ];

                // Update into employee_contact
                $dataContact = [
                    'EmployeeId' => $num,
                    'EmployeeContactEmail' => $email,
                    'EmployeeContactMobile' => $mobile,
                    'EmployeeContactTelephone' => $telephone,
                ];

                if ($employeeImplModel->update($num, $data, $dataImage, $dataContact)) {
                    $employeeFile = $employeeImplModel->employeeImage($num);
                    session()->set('employeeName', $firstName . ' ' . $lastName);
                    session()->set('employeeImage', $employeeFile->fileSrc);
                    session()->set('employeeImageAlt', $employeeFile->fileName);

                    return redirect()->back()->with('success', 'Employee updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating employee!');
                }

            } else
                return $this->edit($num, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function updatePassword(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge(
                $this->fieldNewPassword,
                $this->fieldConfrimNewPassword,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $employeeImplModel = new EmployeeImplModel();
                $passwordLibrary = new PasswordLibrary();

                $confirmNewPassword = $this->request->getPost('confrim_new_password');

                $salt = $passwordLibrary->salt16();
                $combinedPassword = $confirmNewPassword . $salt;

                // Get hashed password
                $hashedPassword = $passwordLibrary->encrypt($combinedPassword);

                // Update into employee_secret
                $dataSecret = [
                    'EmployeeSecretPassword' => $hashedPassword,
                    'EmployeeSecretSalt' => $salt
                ];

                if ($employeeImplModel->updateSecret($num, $dataSecret, false)) {
                    return redirect()->back()->with('success', 'Employee password updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating employee password!');
                }
            } else
                return $this->editPassword($num, $this->validator);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}