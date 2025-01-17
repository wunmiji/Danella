<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Melbahja\Seo\MetaTags;


class Contact extends BaseController
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

    protected $fieldEmail = [
        'email' => [
            'rules' => 'required|valid_email|max_length[70]',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Valid Email is  required',
                'max_length' => 'Max length for name is 70'
            ]
        ],
    ];

    protected $fieldMessage = [
        'message' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Message is required'
            ]
        ]
    ];

    protected $fieldSubject = [
        'subject' => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required' => 'Subject is required',
                'max_length' => 'Max length for subject is 100'
            ]
        ]
    ];




    public function index($validator = null)
    {
        try {
            $metatags = new MetaTags();

            $metatags->title('Contact Us' . $this->metaTitle)
                ->description('Get in touch. ' . $this->information['call'][0] . ' ' . $this->information['call'][1])
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', 'Contact us, Get in touch,' . $this->information['call'][0] . ', ' . $this->information['call'][1])
                ->image(base_url('assets/images/contact-featured-area.jpg'));

            $data['metatags'] = $metatags;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['validation'] = $validator;
            $data['information'] = $this->information;

            return view('contact/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


    public function send()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldName,
                $this->fieldSubject,
                $this->fieldMessage,
                $this->fieldEmail
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $name = $this->request->getVar('name');
                $email = $this->request->getVar('email');
                $subject = $this->request->getVar('subject');
                $message = $this->request->getVar('message');

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                $html = view_cell('\App\Cells\EmailCell::contactForm', ['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);

                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = 'wunmiji@gmail.com';                     //SMTP username
                $mail->Password = 'laqc hykr uvzl aoxu';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = 465;                                    //TCP port to connect to; use 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_SMTPS ENCRYPTION_STARTTLS'
                //Recipients
                $mail->setFrom($email, 'DanellaTech Contact Page');
                $mail->addAddress('wunmiji@gmail.com', $name);// bolajimichealboutique@gmail.com
                //$mail->addReplyTo($email, $name);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body = $html;


                if ($mail->send())
                    return redirect()->back()->with('success', 'Message has been sent successfully!');
                else
                    return redirect()->back()->with('fail', 'Message not sent');
            } else {
                return $this->index($this->validator);
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
