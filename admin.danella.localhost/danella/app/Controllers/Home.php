<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\EmployeeImplModel;
use App\Libraries\PasswordLibrary;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Home extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index($validator = null)
    {
        try {
            $data['title'] = 'Login';
            $data['validation'] = $validator;

            return view('home/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function forgetPassword($validator = null)
    {
        try {
            $data['title'] = 'Forget Password';
            $data['validation'] = $validator;

            return view('home/forget_password', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function resetPassword($validator = null)
    {
        try {
            $data['title'] = 'Forget Password';
            $data['validation'] = $validator;
            $data['token'] = $this->request->getGet('token');

            return view('home/reset_password', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function login()
    {
        try {
            $validated = $this->validate([
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Email is alredy used'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[20]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be 5 characters long',
                        'max_length' => 'Password cannot be longer than 20 characters'
                    ]
                ]
            ]);

            if (!$validated) {
                //return view('index', ['validation' => $this->validator]);
                return $this->index($this->validator);
            } else {
                $employeeImplModel = new EmployeeImplModel();

                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');

                $employeeId = $employeeImplModel->getIdByEmail($email);

                if (!is_null($employeeId)) {
                    $employee = $employeeImplModel->retrieve($employeeId);

                    // Get employee_image
                    $employeeFile = $employee->image;

                    // Set all of employee
                    $employeeSecret = $employee->secret;

                    // Check password with hashed password
                    $passwordLibrary = new PasswordLibrary();


                    $dbPassword = $employeeSecret->password;
                    $dbSalt = $employeeSecret->salt;
                    $combinedPassword = $password . $dbSalt;
                    $checkPassword = $passwordLibrary->check($combinedPassword, $dbPassword);

                    if ($checkPassword) {
                        session()->set('employeeId', $employeeId);
                        session()->set('employeeName', $employee->firstName . ' ' . $employee->lastName);
                        session()->set('employeeImage', $employeeFile->fileSrc);
                        session()->set('employeeImageAlt', $employeeFile->fileName);
                        session()->set('employeeKey', bin2hex(random_bytes(16)));

                        return redirect()->route('dashboard');
                    } else {
                        return redirect()->back()->with('fail', 'Incorrect email or password provided!');
                    }
                } else {
                    return redirect()->back()->with('fail', 'Incorrect email or password provided!');
                }

            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function sendForgetPassword()
    {
        try {
            $validated = $this->validate([
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Email is not valid'
                    ]
                ]
            ]);

            if (!$validated) {
                return $this->forgetPassword($this->validator);
            } else {
                $employeeImplModel = new EmployeeImplModel();

                $email = $this->request->getVar('email');

                $employeeId = $employeeImplModel->getIdByEmail($email);

                if (!is_null($employeeId)) {
                    $employee = $employeeImplModel->retrieve($employeeId);

                    $token = bin2hex(random_bytes(16));
                    $tokenHash = hash("sha256", $token);
                    $minutes = 5;
                    $expiry = date("Y-m-d  H:i:s", time() + 60 * $minutes);

                    $dataSecretReset = [
                        'EmployeeId' => $employeeId,
                        'EmployeeSecretResetToken' => $tokenHash,
                        'EmployeeSecretExpiresAt' => $expiry,
                    ];

                    $employeeImplModel->saveSecretReset($employeeId, $dataSecretReset);


                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);
                    $dataCell = [
                        'name' => $employee->firstName . ' ' . $employee->lastName,
                        'token' => $token,
                        'minutes' => $minutes
                    ];
                    $html = view_cell('\App\Cells\EmailCell::passwordReset', $dataCell);

                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                    $mail->Username = 'wunmiji@gmail.com';                     //SMTP username
                    $mail->Password = 'laqc hykr uvzl aoxu';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port = 465;                                    //TCP port to connect to; use 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_SMTPS ENCRYPTION_STARTTLS'
                    //Recipients
                    $mail->setFrom('madewunmi31@outlook.com');
                    $mail->addAddress($email);
                    //$mail->addReplyTo($email, $name);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = "Password Reset";
                    $mail->Body = $html;

                    if (!$mail->send()) {
                        return redirect()->back()->with('fail', 'Password Reset not sent');
                    }
                } 

                return view('home/forget_password_message', ['title' => 'Forget Password']);

            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            //d($exception);
            //die;
        }
    }

    public function sendResetPassword()
    {
        try {
            $validated = $this->validate([
                'new_password' => [
                    'rules' => 'required|min_length[5]|max_length[20]',
                    'errors' => [
                        'required' => 'Your new password is required',
                        'min_length' => 'Password must be 5 characters long',
                        'max_length' => 'Password cannot be longer than 20 characters'
                    ]
                ],
                'confrim_new_password' => [
                    'rules' => 'required|min_length[5]|max_length[20]|matches[new_password]',
                    'errors' => [
                        'required' => 'Your confirm new password is required',
                        'min_length' => 'Password must be 5 characters long',
                        'max_length' => 'Password cannot be longer than 20 characters',
                        'matches' => 'Your new passwords do not match'
                    ]
                ]
            ]);

            if (!$validated) {
                return $this->resetPassword($this->validator);
            } else {
                $employeeImplModel = new EmployeeImplModel();
                $passwordLibrary = new PasswordLibrary();

                $confirmNewPassword = $this->request->getPost('confrim_new_password');
                $token = $this->request->getPost('tokenHidden');

                $tokenHash = hash("sha256", $token);
                $employeeSecretReset = $employeeImplModel->employeeSecretReset($tokenHash);

                if (is_null($employeeSecretReset))
                    return redirect()->back()->with('fail', 'Token not found!');
                if (strtotime($employeeSecretReset->expiresAt) <= time())
                    return redirect()->back()->with('fail', 'Token has expired!');

                $salt = $passwordLibrary->salt16();
                $combinedPassword = $confirmNewPassword . $salt;

                // Get hashed password
                $hashedPassword = $passwordLibrary->encrypt($combinedPassword);

                // Update into employee_secret
                $dataSecret = [
                    'EmployeeSecretPassword' => $hashedPassword,
                    'EmployeeSecretSalt' => $salt
                ];

                if ($employeeImplModel->updateSecret($employeeSecretReset->id, $dataSecret, true)) {
                    return view('home/reset_password_message', ['title' => 'Reset Password']);
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating your password!');
                }
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
