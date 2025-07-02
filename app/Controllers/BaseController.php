<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\DiskonModel; 

class BaseController extends Controller
{
    protected $helpers = ['form', 'number'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $diskonModel = new DiskonModel();
        $today_diskon = $diskonModel->where('tanggal', date('Y-m-d'))->first();

        if ($today_diskon) {
            session()->set('diskon', $today_diskon['nominal']);
        } else {
            session()->remove('diskon');
        }
    }
}