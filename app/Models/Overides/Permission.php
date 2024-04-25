<?php

namespace App\Models\Overides;

use App\Models\Concerns\HasSchemalessProperties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasSchemalessProperties;
    public static function getDefaultPermissons(): array
    {
        return [
            "dashboard" =>  [
                "dashboard.view",
                "dashboard.universities-view",
                "dashboard.societies-view",
                "dashboard.students-view",
                "dashboard.venues-view",
                "dashboard.events-view",
            ],
            "users" =>  [
                "users.view",
                "users.create",
                "users.edit",
                "users.delete",
                "users.permissions",
            ],
            "roles" => [
                "roles.view",
                "roles.create",
                "roles.assign",
            ],
            "settings" => [
                "settings.view",
                "settings.update",
            ],
            "passwords" => [
                "passwords.view",
                "passwords.update",
            ],
        ];
    }


    public static function getAdminPermissions(): array
    {
        return [
            "universities" =>  [
                "universities.bulk-view",
                "universities.view",
                "universities.detail",
                "universities.create",
                "universities.edit",
                "universities.delete",
            ],
            "societies" =>  [
                "societies.bulk-view",
                "societies.view",
                "societies.detail",
                "societies.create",
                "societies.edit",
                "societies.delete",
            ],
            "students" =>  [
                "students.bulk-view",
                "students.view",
                "students.detail",
                "students.delete",
            ],
            "venues" => [
                "venues.bulk-view",
                "venues.view",
                "venues.detail",
                "venues.create",
                "venues.edit",
                "venues.delete",
            ],
            "events" => [
                "events.bulk-view",
                "events.view",
                "events.detail",
                "events.create",
                "events.edit",
                "events.delete",
            ],
            "partners" =>  [
                "partners.bulk-view",
                "partners.view",
                "partners.detail",
                "partners.delete",
            ],

        ];
    }

}
