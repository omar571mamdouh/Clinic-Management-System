<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // ========== Permissions ==========
        $permissions = [

            // Dashboard
            'view dashboard',

            // Patients
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',

            // Appointments
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',

            // Doctors
            'view doctors',
            'create doctors',
            'edit doctors',
            'delete doctors',

            // Medical Records
            'view medical-records',
            'create medical-records',
            'delete medical-records',

            // Payments
            'view payments',

            // Notifications
            'view notifications',

            // Activity Logs
            'view activity-logs',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Roles
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ========== Roles ==========

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // Doctor
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctor->syncPermissions([
            'view dashboard',

            'view patients',

            'view appointments',

            'view doctors',
            'edit doctors',

            'view medical-records',
            'create medical-records',

            'view payments',
            'view notifications',
            'view activity-logs',
        ]);

        // Receptionist
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->syncPermissions([
            'view dashboard',

            'view patients',
            'create patients',
            'edit patients',

            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',

            'view medical-records',
            'create medical-records',

            'view payments',
            'view notifications',
            'view activity-logs',
        ]);

        // ========== Default Users ==========

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@clinic.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
            ]
        );

        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@clinic.com'],
            [
                'name' => 'Doctor User',
                'password' => bcrypt('password123'),
            ]
        );

        $receptionistUser = User::firstOrCreate(
            ['email' => 'receptionist@clinic.com'],
            [
                'name' => 'Receptionist User',
                'password' => bcrypt('password123'),
            ]
        );

        // ========== Assign Roles ==========
        $adminUser->syncRoles('admin');
        $doctorUser->syncRoles('doctor');
        $receptionistUser->syncRoles('receptionist');
    }
}