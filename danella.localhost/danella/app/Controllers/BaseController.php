<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['text', 'form'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;
    protected $metaTitle = ' | DanellaTech';
    protected $metaAuthor = 'DanellaTech';
    protected $information = [
        'name' => 'Danellatech',
        'website' => 'https://www.danellatech.com',
        'address' => '58 Brown St, Mafoluku Oshodi, Lagos 102214, Lagos',
        'email' => ['info@danellatech.com'],
        'call' => ['(+234) 906 0112 757', '(+234) 906 0112 757'],
        'working' => ['Mon - Sat 09:00 - 17:00.', 'Sunday CLOSED'],
        'founded' => 2017,
        'facebook' => 'https://web.facebook.com/',
        'instagram' => 'https://www.instagram.com/',
        'linkedin' => 'https://www.linkedin.com/',
        'twitter' => 'https://twitter.com',
        'youtube' => 'https://www.youtube.com/',
    ];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
