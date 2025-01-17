<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;
use App\ImplModel\BlogImplModel;

use Melbahja\Seo\MetaTags;


class Blog extends BaseController
{

    public function index()
    {
        try {
            $blogImplModel = new BlogImplModel();
            $metatags = new MetaTags();

            $metatags->title('Blog' . $this->metaTitle)
                ->description('View all our projects')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/featured-area.jpg'));

            $queryCount = $this->request->getVar('page');
            if (is_null($queryCount)) {
                $pagination = $blogImplModel->pagination(1);

                $data['metatags'] = $metatags;
                $data['data'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];
                $data['baseUrl'] = 'blog?page=';
                $data['information'] = $this->information;

                return view('blog/index', $data);
            } else {
                $pagination = $blogImplModel->pagination($queryCount);

                $data['data'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];

                return view('include/load_blogs', $data);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details($slug)
    {
        try {
            $blogImplModel = new BlogImplModel();
            $metatags = new MetaTags();

            // blog detais
            $blog = $blogImplModel->retrieve($slug);
            $blogImage = $blog->image;
            $blogText = $blog->text;
            $blogAuthor = $blog->author;
            $blogCategories = $blog->categories;

            // Related blog
            $relatedBlogs = array();
            $blogCategoriesId = array_column($blogCategories, 'categoryId');
            $relatedBlogs = $blogImplModel->related($blogCategoriesId);

            $metatags->title($blog->title  . $this->metaTitle)
                ->description($blog->summary)
                ->meta('author', ' ' . $blogAuthor->name)
                ->meta('keywords', $blog->title)
                ->image($blogImage->fileSrc);

            $data['metatags'] = $metatags;
            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">';
            $data['js_files'] = '<script src="/assets/js/custom/service_details.js"></script>';
            $data['data'] = $blog;
            $data['dataImage'] = $blogImage;
            $data['dataText'] = $blogText;
            $data['dataAuthor'] = $blogAuthor;
            $data['dataCategories'] = $blogCategories;
            $data['relatedBlogs'] = $relatedBlogs;
            $data['information'] = $this->information;

            return view('blog/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}
