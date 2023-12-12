<?php

namespace App\Controllers;

use App\Models\Publication;

class HomeController extends Controller
{
    public function index()
    {              
        return $this->view('home');        
    }
    public function about()
    {
        return $this->view('about');
    }
        
}