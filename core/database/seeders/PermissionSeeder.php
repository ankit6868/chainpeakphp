<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Manage Dashboard',
            "Manage Users",
            "Manage Gateway",
            "Manage Deposit",
            "Manage Withdraw",
            "Manage Support Ticket",
            "Manage Report",
            "Manage Subscriber",
            "Manage Staff",
            "Manage Category",
            "Manage Subcategory",
            "Manage Feature",
            "Manage Advertisement",
            "Manage Level",
            "Manage Coupon",
            "Manage Service",
            "Manage Job",
            "Manage Software",
            "Manage Service Booking",
            "Manage Job Bidding",
            "Manage Software Sales",
            "Manage Payment",
            "Manage General Setting",
            "Manage System Configuration",
            "Manage Logo & Favicon",
            "Manage Extension",
            "Manage Language",
            "Manage SEO Manager",
            "Manage KYC Setting",
            "Manage Notification Setting",
            "Manage Template",
            "Manage Frontend Section",
            "Manage Maintenance Mode",
            "Manage GDPR Cookie",
            "Others"
        ];

        foreach ($permissions as $permission) {
            $newPermission = Permission::where('name', $permission)->exists();
            if (!$newPermission) {
                $newPermission             = new Permission();
                $newPermission->name       = $permission;
                $newPermission->guard_name = "admin";
                $newPermission->save();
            }
        }
    }
}
