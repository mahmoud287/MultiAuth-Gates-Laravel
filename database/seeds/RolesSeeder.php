<?php

use App\role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author = role::create([
            'name' => 'Author',
            'slug' => 'author',
            'permissions' => [
                'create-post' => true,
            ],
        ]);
        $editor = role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => [
                'update-post' => true,
                'publish-post' => true,
            ],
        ]);
    }
}
