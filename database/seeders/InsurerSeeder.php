<?php

namespace Database\Seeders;

use App\Models\Insurer;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InsurerSeeder extends Seeder
{
    const INSURERS = [
        [
            'name' => 'ALLIANZ Hungária Biztosító Zrt.',
            'short_name' => 'Allianz'
        ],
        [
            'name' => 'Alfa Vienna Insurance Group Zrt.',
            'short_name' => 'Alfa'
        ],
        [
            'name' => 'CIG-Pannónia Első Magyar Általános Biztosító Zrt.',
            'short_name' => 'CIG Általános'
        ],
        [
            'name' => 'CIG-Pannónia Életbiztosító Nyrt.',
            'short_name' => 'CIG Élet'
        ],
        [
            'name' => 'COLONNADE Insurance S.A. Magyarországi Fióktelepe',
            'short_name' => 'Colonnade'
        ],
        [
            'name' => 'GENERALI Biztosító Zrt.',
            'short_name' => 'Generali'
        ],
        [
            'name' => 'GENERTEL Biztosító Zrt.',
            'short_name' => 'Genertel'
        ],
        [
            'name' => 'K&H Biztosító Zrt.',
            'short_name' => 'K&H'
        ],
        [
            'name' => 'KöBE Közép-európai Kölcsönös Biztosító Egyesület',
            'short_name' => 'KöBE'
        ],
        [
            'name' => 'Magyar Posta Biztosító Zrt.',
            'short_name' => 'Magyar Posta'
        ],
        [
            'name' => 'MetLife Biztosító Zrt.',
            'short_name' => 'MetLife'
        ],
        [
            'name' => 'SIGNAL IDUNA Biztosító Zrt.',
            'short_name' => 'Signal'
        ],
        [
            'name' => 'UNION Vienna Insurance Group Biztosító Zrt.',
            'short_name' => 'Union'
        ],
        [
            'name' => 'UNIQA Biztosító Zrt.',
            'short_name' => 'Uniqa'
        ],
        [
            'name' => 'Gránit Biztosító Zrt.',
            'short_name' => 'Gránit'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Insurer::query()->delete();

        $this->createInsurers();
        $this->createPermissions();
    }

    private function createInsurers()
    {
        foreach (self::INSURERS as $insurer) {
            Insurer::create($insurer);
        }
    }

    private function createPermissions()
    {
        $permissions = [
            'view insurers',
            'edit insurers',
            'delete insurers'
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // Attach permissions to the developer role
        $developer = Role::where('name', 'developer')->first();
        $developer->givePermissionTo($permissions);
    }
}
