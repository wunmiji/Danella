<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\ServiceImplModel;

use Melbahja\Seo\MetaTags;


class Service extends BaseController
{

    public function index()
    {
        try {
            $serviceImplModel = new ServiceImplModel();
            $metatags = new MetaTags();

            $metatags->title('Services' . $this->metaTitle)
                ->description('We offer a lot of services')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/services-featured-area.jpg'));


            $services = $serviceImplModel->list();

            $data['metatags'] = $metatags;
            $data['data'] = $services;
            $data['information'] = $this->information;

            return view('services/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details($slug)
    {
        try {
            $serviceImplModel = new ServiceImplModel();
            $metatags = new MetaTags();

            $service = $serviceImplModel->slug($slug);

            $serviceImage = $service->image;
            $serviceText = $service->text;
            $serviceFaqs = $service->faqs;
            $services = $serviceImplModel->listName();

            $metatags->title($service->name . $this->metaTitle)
                ->description($service->description)
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', $service->name)
                ->image(base_url('assets/images/projects-featured-area.jpg'));


            $data['metatags'] = $metatags;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/accordion.css">';
            $data['js_files'] = '<script src="/assets/js/custom/service_details.js"></script>';
            $data['data'] = $service;
            $data['dataImage'] = $serviceImage;
            $data['dataText'] = $serviceText;
            $data['dataFaqs'] = $serviceFaqs;
            $data['dataServices'] = $services;
            $data['information'] = $this->information;

            return view('services/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
