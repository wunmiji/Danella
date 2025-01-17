<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\TestimonialImplModel;

use Melbahja\Seo\MetaTags;


class About extends BaseController
{

    public function index()
    {
        try {
            $testimonialImplModel = new TestimonialImplModel();
            $metatags = new MetaTags();

            $testimonials = $testimonialImplModel->list(0, 5);
            $metatags->title('About' . $this->metaTitle)
                ->description('Danellatech is a reputable technology firm 
                specializing in the provision of sustainable solar solutions, 
                CCTV installations, network setups, and various other services.')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/contact-featured-area.jpg'));

            $data['metatags'] = $metatags;
            $data['js_files'] = '<script src="/assets/js/library/swiper-bundle.min.js"></script>' .
                '<script src= "/assets/js/custom/swiper.js"></script>';
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/library/swiper-bundle.min.css" />';
            $data['information'] = $this->information;
            $data['testimonials'] = $testimonials;

            return view('about/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
