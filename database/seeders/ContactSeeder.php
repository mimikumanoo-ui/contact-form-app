<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();

        Contact::factory()->count(20)->create()->each(function ($contact) use ($tags) {
            if ($tags->isNotEmpty()) {
                $randomTags = $tags->random(rand(1, min(3, $tags->count())))->pluck('id');
                $contact->tags()->attach($randomTags);
            }
        });
    }
}
