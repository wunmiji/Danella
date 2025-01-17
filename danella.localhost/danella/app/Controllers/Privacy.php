<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use Melbahja\Seo\MetaTags;


class Privacy extends BaseController
{

    public function index()
    {
        try {
            $metatags = new MetaTags();

            $metatags->title('Privacy' . $this->metaTitle)
                ->description('Our policy')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/privacy-policy-featured-area.jpg'));

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;

            return view('privacy/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
