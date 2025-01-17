<?php

namespace App\Controllers;


use App\Controllers\BaseController;

use Melbahja\Seo\MetaTags;

class Errors extends BaseController
{

    public function show404()
    {
        try {
            // Set 404 status code
            $this->response->setStatusCode(404);

            $metatags = new MetaTags();

            $metatags->title('Page not found' . $this->metaTitle)
                ->description('Page cannot be found')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/error-featured-area.jpg'));

            $data['metatags'] = $metatags;


            return view('404', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
        }
    }




}
