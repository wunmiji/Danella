<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use Melbahja\Seo\MetaTags;


class Terms extends BaseController
{

    public function index() 
    {
        try {
            $metatags = new MetaTags();

            $metatags->title('Terms' . $this->metaTitle)
                ->description('Our terms')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/terms-featured-area.jpg'));

            $data['metatags'] = $metatags;

            $data['title'] = 'Terms';
            $data['description'] = 'Our terms';
            $data['keywords'] = 'Terms';
            $data['information'] = $this->information;

            return view('terms/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
