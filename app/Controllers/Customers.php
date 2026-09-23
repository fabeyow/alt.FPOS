<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();
        $customers     = $customerModel->findAll();

        $data = [
            'title'           => 'Customer Accounts',
            'metaDescription' => 'View all registered customer accounts in the alt.FPOS system.',
            'activeNav'       => 'customers',
            'customers'       => $customers,
        ];

        return view('customers/index', $data);
    }
}
