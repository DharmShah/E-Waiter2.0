<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Chef extends BaseController
{
    public function chefdashboard()
    {
        return view('chefdashboard');
    }
}
