<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\ServiceImplModel;
use App\ImplModel\TestimonialImplModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Melbahja\Seo\MetaTags;


class GetQuote extends BaseController
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

    protected $fieldCompanyName = [
        'company_name' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'Company Name is required',
                'max_length' => 'Max length for company name is 30'
            ]
        ]
    ];

    protected $fieldPhone = [
        'phone' => [
            'rules' => 'required|max_length[15]|is_natural',
            'errors' => [
                'required' => 'Phone is required',
                'max_length' => 'Max length for phone number is 15',
                'is_natural' => 'Phone is not valid',
            ]
        ]
    ];


    public function index($validator = null)
    {
        try {
            $serviceImplModel = new ServiceImplModel();
            $testimonialImplModel = new TestimonialImplModel();
            $metatags = new MetaTags();

            $services = $serviceImplModel->listName();
            $testimonials = $testimonialImplModel->list(0, 5);
            $metatags = new MetaTags();

            $description = 'Get started today and experience the convenience of receiving a quick quote.';
            $metatags->title('Get a Quote' . $this->metaTitle)
                ->description($description)
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', 'Get a quote about cctv, solar')
                ->image(base_url('assets/images/get-a-quote-featured-area.jpg'));

            $data['metatags'] = $metatags;
            $data['description'] = $description;
            $data['js_files'] = '<script src="/assets/js/library/swiper-bundle.min.js"></script>' .
                '<script src= "/assets/js/custom/swiper.js"></script>';
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/swiper-bundle.min.css" >' .
                '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['validation'] = $validator;
            $data['services'] = $services;
            $data['information'] = $this->information;
            $data['testimonials'] = $testimonials;

            return view('get_quote/index', $data);
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
                $this->fieldCompanyName,
                $this->fieldMessage,
                $this->fieldPhone,
                $this->fieldEmail
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $name = $this->request->getVar('name');
                $email = $this->request->getVar('email');
                $companyName = $this->request->getVar('company_name');
                $services = $this->request->getVar('services') ?? array();
                $phone = $this->request->getVar('phone');
                $message = $this->request->getVar('message');

                $quoteForm = [
                    'name' => $name,
                    'email' => $email,
                    'companyName' => $companyName,
                    'services' => $services,
                    'telephone' => $phone,
                    'message' => $message
                ];

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                $html = view_cell('\App\Cells\EmailCell::quoteForm', $quoteForm);

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
                $mail->setFrom($email, 'DanellaTech Get Quote Page');
                $mail->addAddress('wunmiji@gmail.com', $name);// bolajimichealboutique@gmail.com
                //$mail->addReplyTo($email, $name);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $companyName;
                $mail->Body = $html;


                if ($mail->send())
                    return redirect()->back()->with('success', 'Quote has been sent successfully!');
                else
                    return redirect()->back()->with('fail', 'Quote not sent');
            } else {
                return $this->index($this->validator);
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}
