<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update roles
        $superAdminRole = Role::firstOrCreate(['name' => 'principal']);
        $adviserRole = Role::firstOrCreate(['name' => 'adviser']);

        // Create principal only if no super-admin exists
        if (User::role('principal')->count() === 0) {
            $principal = User::create([
                'name' => env('PRINCIPAL_NAME', 'Principal Name'),
                'email' => env('PRINCIPAL_EMAIL', 'principal@deped.gov.ph'),
                'password' => Hash::make(env('PRINCIPAL_PASSWORD', 'securepassword123')),
                'role' => 'Principal',
                'email_verified_at' => now(),
                'approved' => true,
            ]);
            $principal->assignRole($superAdminRole);
        }

        // Grade 7 Advisers
        $advisers = [
            // Grade 7 Advisers
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos7a@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '7',
            ],
            [
                'name' => 'Carlos Dela Cruz',
                'email' => 'carlos.delacruz7b@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '7',
            ],
            [
                'name' => 'Angela Reyes',
                'email' => 'angela.reyes7c@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '7',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe7d@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '7',
            ],

            // Grade 8 Advisers
            [
                'name' => 'Patrick Mendoza',
                'email' => 'patrick.mendoza8a@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '8',
            ],
            [
                'name' => 'Liza Ramos',
                'email' => 'liza.ramos8b@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '8',
            ],
            [
                'name' => 'Erwin Bautista',
                'email' => 'erwin.bautista8c@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '8',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane.doe8d@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '8',
            ],

            // Grade 9 Advisers
            [
                'name' => 'Nina Cruz',
                'email' => 'nina.cruz9a@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '9',
            ],
            [
                'name' => 'Ramon Flores',
                'email' => 'ramon.flores9b@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '9',
            ],
            [
                'name' => 'Jenny Lim',
                'email' => 'jenny.lim9c@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '9',
            ],
            [
                'name' => 'Peter Parker',
                'email' => 'peter.parker9d@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '9',
            ],

            // Grade 10 Advisers
            [
                'name' => 'Allan Rivera',
                'email' => 'allan.rivera10a@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '10',
            ],
            [
                'name' => 'Bea Tan',
                'email' => 'bea.tan10b@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '10',
            ],
            [
                'name' => 'Samuel Ong',
                'email' => 'samuel.ong10c@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '10',
            ],
            [
                'name' => 'Clark Kent',
                'email' => 'clark.kent10d@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '10',
            ],

            // Grade 11 Advisers
            [
                'name' => 'Clara Bautista',
                'email' => 'clara.bautista11a@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '11',
            ],
            [
                'name' => 'Mark Chua',
                'email' => 'mark.chua11b@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '11',
            ],
            [
                'name' => 'Sophia Dizon',
                'email' => 'sophia.dizon11c@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '11',
            ],
            [
                'name' => 'Bruce Wayne',
                'email' => 'bruce.wayne11d@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '11',
            ],

            // Grade 12 Advisers
            [
                'name' => 'Joshua Navarro',
                'email' => 'joshua.navarro12a@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '12',
            ],
            [
                'name' => 'Ella Ramos',
                'email' => 'ella.ramos12b@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '12',
            ],
            [
                'name' => 'Miguel Santiago',
                'email' => 'miguel.santiago12c@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '12',
            ],
            [
                'name' => 'Diana Prince',
                'email' => 'diana.prince12d@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Adviser',
                'assigned_grade_level' => '12',
            ],
        ];

        foreach ($advisers as $adviser) {
            if (!User::where('email', $adviser['email'])->exists()) {
                $user = User::create(array_merge($adviser, [
                    'email_verified_at' => now(),
                    'approved' => true, // Auto-approved for dev
                ]));
                $user->assignRole($adviserRole);
            }
        }
    }
}
