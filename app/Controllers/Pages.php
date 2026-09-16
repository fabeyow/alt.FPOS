<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function home(): string
    {
        $data = [
            'title'           => 'Home',
            'metaDescription' => 'alt.FPOS — A modern Point-of-Sale system built with CodeIgniter 4. Manage customers and users easily.',
            'activeNav'       => 'home',
        ];

        return view('pages/home', $data);
    }

    public function about(): string
    {
        $data = [
            'title'           => 'About',
            'metaDescription' => 'Learn about alt.FPOS, the technologies used, and the project roadmap.',
            'activeNav'       => 'about',
        ];

        return view('pages/about', $data);
    }
}
