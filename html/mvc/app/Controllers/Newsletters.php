<?php

namespace App\Controllers;

class Newsletters extends BaseController
{
    public function index(): string
    {
        return view('newsletters');
    }

     public function single(): string
    {
        return view('single_newsletter');
    }
}