<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // -------------------------------------------------
        // Seed Customers (5 records)
        // -------------------------------------------------
        $customers = [
            [
                'full_name'  => 'Maria Clara Santos',
                'email'      => 'maria.santos@email.com',
                'phone'      => '+63 917 123 4567',
                'created_at' => '2025-01-15 08:30:00',
            ],
            [
                'full_name'  => 'Juan Carlos Dela Cruz',
                'email'      => 'jc.delacruz@email.com',
                'phone'      => '+63 928 234 5678',
                'created_at' => '2025-02-20 10:15:00',
            ],
            [
                'full_name'  => 'Angela Mae Reyes',
                'email'      => 'angela.reyes@email.com',
                'phone'      => '+63 935 345 6789',
                'created_at' => '2025-03-10 14:45:00',
            ],
            [
                'full_name'  => 'Roberto Miguel Torres',
                'email'      => 'roberto.torres@email.com',
                'phone'      => '+63 906 456 7890',
                'created_at' => '2025-04-05 09:00:00',
            ],
            [
                'full_name'  => 'Patricia Anne Garcia',
                'email'      => 'patricia.garcia@email.com',
                'phone'      => '+63 912 567 8901',
                'created_at' => '2025-05-18 16:20:00',
            ],
        ];

        $this->db->table('customers')->insertBatch($customers);

        // -------------------------------------------------
        // Seed Users (5 records)
        // -------------------------------------------------
        $users = [
            [
                'username'   => 'admin_jose',
                'full_name'  => 'Jose Andres Mendoza',
                'role'       => 'Admin',
                'created_at' => '2025-01-01 08:00:00',
            ],
            [
                'username'   => 'mgr_carmela',
                'full_name'  => 'Carmela Rose Villanueva',
                'role'       => 'Manager',
                'created_at' => '2025-01-15 09:30:00',
            ],
            [
                'username'   => 'cash_diego',
                'full_name'  => 'Diego Martin Flores',
                'role'       => 'Cashier',
                'created_at' => '2025-02-01 10:00:00',
            ],
            [
                'username'   => 'cash_liza',
                'full_name'  => 'Liza Mae Aquino',
                'role'       => 'Cashier',
                'created_at' => '2025-02-15 11:00:00',
            ],
            [
                'username'   => 'staff_marco',
                'full_name'  => 'Marco Antonio Bautista',
                'role'       => 'Staff',
                'created_at' => '2025-03-01 08:30:00',
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
