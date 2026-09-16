<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index(): string
    {
        $users = [
            [
                'username'  => 'admin_jose',
                'full_name' => 'Jose Andres Mendoza',
                'role'      => 'Admin',
            ],
            [
                'username'  => 'mgr_carmela',
                'full_name' => 'Carmela Rose Villanueva',
                'role'      => 'Manager',
            ],
            [
                'username'  => 'cash_diego',
                'full_name' => 'Diego Martin Flores',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'cash_liza',
                'full_name' => 'Liza Mae Aquino',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'staff_marco',
                'full_name' => 'Marco Antonio Bautista',
                'role'      => 'Staff',
            ],
        ];

        $data = [
            'title'           => 'User Accounts',
            'metaDescription' => 'Manage staff and system user accounts in the alt.FPOS system.',
            'activeNav'       => 'users',
            'users'           => $users,
        ];

        return view('users/index', $data);
    }
}
