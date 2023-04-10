<?php

namespace App\Observers;

use App\Models\Recipe;
use App\Models\Log;

class RecipeObserver
{
    /**
     * Handle the Recipe "created" event.
     */
    public function created(Recipe $recipe): void
    {
        Log::create([
            'module' => 'tambah resep',
            'action' => 'tambah resep'.$recipe->judul.' dengan id '.$recipe->id,
            'useraccess' => $recipe->user_email
        ]);
    }

    /**
     * Handle the Recipe "updated" event.
     */
    public function updated(Recipe $recipe): void
    {
        Log::create([
            'module' => 'sunting resep',
            'action' => 'sunting resep menjadi '.$recipe->judul.' dengan id '.$recipe->id,
            'useraccess' => $recipe->user_email
        ]);
    }

    /**
     * Handle the Recipe "deleted" event.
     */
    public function deleted(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "restored" event.
     */
    public function restored(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "force deleted" event.
     */
    public function forceDeleted(Recipe $recipe): void
    {
        //
    }
}
