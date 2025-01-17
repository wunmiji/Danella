<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\TestimonialImplModel;

use Melbahja\Seo\MetaTags;


class Testimonials extends BaseController
{

    public function index()
    {
        try {
            $testimonialImplModel = new TestimonialImplModel();
            $metatags = new MetaTags();

            $metatags->title('Testimonials' . $this->metaTitle)
                ->description('See all our happy clients')
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', 'Testimonials, happy customers, happy clients')
                ->image(base_url('assets/images/clients-featured-area.jpg'));

            $queryCount = $this->request->getVar('page');
            if (is_null($queryCount)) {
                $pagination = $testimonialImplModel->pagination(1);

                $data['metatags'] = $metatags;
                $data['data'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['baseUrl'] = 'testimonials?page=';
                $data['information'] = $this->information;

                return view('testimonials/index', $data);
            } else {
                $pagination = $testimonialImplModel->pagination($queryCount);

                $data['data'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];

                return view('include/load_testimonials', $data);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
