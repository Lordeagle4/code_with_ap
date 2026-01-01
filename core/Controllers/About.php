<?php declare(strict_types=1);

namespace Core\Controllers;

use Core\Views\View;

class About
{
    public function index(): void
    {
        View::render('about', ['title' => 'About Us']);
    }
}
