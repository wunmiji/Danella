<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\ProjectImplModel;

use Melbahja\Seo\MetaTags;

class Project extends BaseController
{
    public function index()
    {
        try {
            $projectImplModel = new ProjectImplModel();
            $metatags = new MetaTags();

            $metatags->title('Projects' . $this->metaTitle)
                ->description('View all our projects')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/projects-featured-area.jpg'));

            $queryCount = $this->request->getVar('page');
            if (is_null($queryCount)) {
                $pagination = $projectImplModel->pagination(1);

                $data['metatags'] = $metatags;
                $data['data'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];
                $data['baseUrl'] = 'projects?page=';
                $data['information'] = $this->information;

                return view('projects/index', $data);
            } else {
                $pagination = $projectImplModel->pagination($queryCount);

                $data['data'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];

                return view('include/load_projects', $data);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details($slug)
    {
        try {
            $projectImplModel = new ProjectImplModel();
            $metatags = new MetaTags();

            $project = $projectImplModel->slug($slug);

            $projectImage = $project->image;
            $projectText = $project->text;
            $projectServices = $project->services;
            $projectGallary = $project->gallary;

            $metatags->title($project->name . $this->metaTitle)
                ->description($project->name)
                ->meta('author', ' ' . $this->metaAuthor)
                ->meta('keywords', $project->name)
                ->image($projectImage->fileSrc);

            $data['metatags'] = $metatags;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src="/assets/js/custom/project_details.js"></script>';
            $data['data'] = $project;
            $data['dataImage'] = $projectImage;
            $data['dataText'] = $projectText;
            $data['dataServices'] = $projectServices;
            $data['dataGallary'] = $projectGallary;
            $data['information'] = $this->information;

            return view('projects/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

}