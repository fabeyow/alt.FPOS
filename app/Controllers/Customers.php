<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = [
            [
                'full_name' => 'Maria Clara Santos',
                'email'     => 'maria.santos@email.com',
                'phone'     => '+63 917 123 4567',
            ],
            [
                'full_name' => 'Juan Carlos Dela Cruz',
                'email'     => 'jc.delacruz@email.com',
                'phone'     => '+63 928 234 5678',
            ],
            [
                'full_name' => 'Angela Mae Reyes',
                'email'     => 'angela.reyes@email.com',
                'phone'     => '+63 935 345 6789',
            ],
            [
                'full_name' => 'Roberto Miguel Torres',
                'email'     => 'roberto.torres@email.com',
                'phone'     => '+63 906 456 7890',
            ],
            [
                'full_name' => 'Patricia Anne Garcia',
                'email'     => 'patricia.garcia@email.com',
                'phone'     => '+63 912 567 8901',
            ],
        ];

        $data = [
            'title'           => 'Customer Accounts',
            'metaDescription' => 'View all registered customer accounts in the alt.FPOS system.',
            'activeNav'       => 'customers',
            'customers'       => $customers,
        ];

        return view('customers/index', $data);
    }
}
