<?php


namespace App\Controllers;

use App\Controllers\BaseController;

class Errors extends BaseController {

    public function show404 () {
        try {
            // Set 404 status code
            $this->response->setStatusCode(404);

            $data['title'] = 'Page not found';


            return view('404', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
        }
    }




}
