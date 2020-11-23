<?php

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // On crée le dossier s'il n'existe pas
        if(!Storage::exists('/app/images/events'))
            Storage::makeDirectory('/app/images/events');

        Image::create(['title' => 'Combattre le coronavirus',
            'description' => 'Combattre le coronavirus nécessite des protections renforcées.',
            'name' => 'f350e7ac542ab48a23d3ff1541c6de0fedb5550a.jpg',
            'old_name' => 'protective-suit-5716753_1920.jpg']);

        Image::create(['title' => 'Formum sur la médecine',
            'description' => 'Forum sur la médecine semaine dernière, il s\'est très bien passé. Parfaitement bien passé. C\'est super !',
            'name' => '92b8c3349d4141c24938e4c7534b8cc0a6deadb2.jpg',
            'old_name' => 'medic-563423_1920.jpg']);

        Image::create(['title' => 'La médecine c\'est important',
            'description' => 'Comment ferions nous sans un personnel compétant ?',
            'name' => '44334e5423808b3a42deca6d03da38dc578336f1.jpg',
            'old_name' => 'surgery-1822458_1920.jpg']);

        Image::create(['title' => 'Coronavirus',
            'description' => 'Veuillez vous laver les mains régulièrement! C\'est très important',
            'name' => '681bcc21bc3cf2f161a225681f0cba961b12c953.jpg',
            'old_name' => 'wash-4934590_1920.jpg']);

    }
}
