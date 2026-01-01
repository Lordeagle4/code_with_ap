<?php declare(strict_types=1);

namespace Core\Controllers;

use Core\Views\View;

class Home
{
    public function index(): void
    {
        View::render('home/index', ['title' => 'Home Page']);
    }
}