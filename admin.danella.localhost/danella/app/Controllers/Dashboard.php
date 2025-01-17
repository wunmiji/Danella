<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\ServiceImplModel;
use App\ImplModel\ProjectImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\BlogImplModel;
use App\Libraries\FileLibrary;

class Dashboard extends BaseController
{

    public function index()
    {
        try {
            $serviceImplModel = new ServiceImplModel();
            $projectImplModel = new ProjectImplModel();
            $fileManagerImplModel = new FileManagerImplModel();
            $blogImplModel = new BlogImplModel();

            $servicePerProject = $serviceImplModel->servicePerProject();
            $servicePerBlog = $serviceImplModel->servicePerBlog();
            $serviceName = $serviceImplModel->serviceNameChart();

            if ($this->request->isAJAX()) {
                $projectPerMonthYear = $this->request->getVar('project_per_month_year');
                if (!is_null($projectPerMonthYear)) return $projectImplModel->projectPerMonth($projectPerMonthYear);

                $blogPerMonthYear = $this->request->getVar('blog_per_month_year');
                if (!is_null($blogPerMonthYear)) return $blogImplModel->blogPerMonth($blogPerMonthYear);
            }
            $projectPerMonth = $projectImplModel->projectPerMonth(date('Y'));
            $blogPerMonth = $blogImplModel->blogPerMonth(date('Y'));

            $sumAllFileSize = $fileManagerImplModel->sumAllFileSize();
            $freeSpace = $fileManagerImplModel->maxFileManagerSize - $sumAllFileSize;

            $data['title'] = 'Dashboard';
            $data['js_files'] = '<script type="module" src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>' .
                '<script type="module" src="/assets/js/library/chart-utils.min.js"></script>' . 
                '<script type="module" src="/assets/js/custom/chart.js"></script>';
            $data['serviceName'] = $serviceName;
            $data['servicePerProject'] = $servicePerProject;
            $data['servicePerBlog'] = $servicePerBlog;
            $data['founded'] = $this->information['founded'];
            $data['projectPerMonth'] = $projectPerMonth;
            $data['blogPerMonth'] = $blogPerMonth;
            $data['usedSpace'] = $sumAllFileSize;
            $data['totalSpace'] = $fileManagerImplModel->maxFileManagerSize;
            $data['freeSpace'] = $freeSpace;
            $data['usedSpaceFormat'] = FileLibrary::formatBytes($sumAllFileSize);
            $data['totalSpaceFormat'] = FileLibrary::formatBytes($fileManagerImplModel->maxFileManagerSize);
            $data['freeSpaceFormat'] = FileLibrary::formatBytes($freeSpace);



            return view('dashboard/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }

    public function logout()
    {
        if (session()->has('employeeId')) {
            session()->remove('employeeId');
        }
        //session()->destroy();
        return redirect()->route('/')->with('fail', 'You are logged out!');
    }

}
