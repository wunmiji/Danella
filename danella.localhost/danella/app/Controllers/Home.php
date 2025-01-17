<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\TestimonialImplModel;
use App\ImplModel\ProjectImplModel;
use App\ImplModel\BlogImplModel;

use Melbahja\Seo\Schema;
use Melbahja\Seo\Schema\Thing;
use Melbahja\Seo\MetaTags;

class Home extends BaseController
{

    public function index()
    {
        try {
            $testimonialImplModel = new TestimonialImplModel();
            $projectImplModel = new ProjectImplModel();
            $blogImplModel = new BlogImplModel();
            $metatags = new MetaTags();

            $testimonials = $testimonialImplModel->list(0, 3);
            $blogs = $blogImplModel->list(0, 3);

            $metatags->title('Homepage' . $this->metaTitle)
                ->description('Danellatech is a reputable technology firm specializing 
                    in the provision of sustainable solar solutions, CCTV installations, 
                    network setups, and various other services.')
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', 'Solar, Solar Installation, CCTV, Network Installation, Danella, DanellaTech')
                ->image(base_url('assets/images/featured-area.jpg'));
            $schema = new Schema(
                new Thing('Organization', [
                    'url' => base_url(),
                    'name' => $this->information['name'],
                    'foundingDate' => $this->information['founded'],
                    'logo' => base_url('assets/brand/danellatech-logo.png'),
                    'description' => 'Danellatech is a reputable technology firm specializing 
                            in the provision of sustainable solar solutions, CCTV installations, 
                            network setups, and various other services.',
                    'location' => $this->information['address'],
                    'sameAs' => [
                        $this->information['facebook'],
                        $this->information['instagram'],
                        $this->information['linkedin'],
                        $this->information['twitter'],
                        $this->information['youtube'],
                    ],
                    'contactPoint' => new Thing('ContactPoint', [
                        'telephone' => implode(', ', $this->information['call']),
                        'contactType' => 'customer service'
                    ])
                ])
            );

            $data['metatags'] = $metatags;
            $data['schema'] = $schema;
            $data['js_files'] = '<script type="module" src="/assets/js/library/countUp.min.js"></script>' .
                '<script type="module" src="/assets/js/custom/countup.js"></script>';
            $data['testimonials'] = $testimonials;
            $data['blogs'] = $blogs;
            $data['countUpTestimonials'] = intval($testimonialImplModel->count());
            $data['countUpProjects'] = intval($projectImplModel->count());
            $data['countUpYears'] = date('Y') - $this->information['founded'];
            $data['information'] = $this->information;

            return view('home/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


}
