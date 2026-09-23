<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();
        $users     = $userModel->findAll();

        $data = [
            'title'           => 'User Accounts',
            'metaDescription' => 'Manage staff and system user accounts in the alt.FPOS system.',
            'activeNav'       => 'users',
            'users'           => $users,
        ];

        return view('users/index', $data);
    }
}
