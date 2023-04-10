<?php

namespace App\Observers;

use App\Models\Ingredients;
use App\Models\Log;

class IngredientObserver
{
    /**
     * Handle the Ingredients "created" event.
     */
    public function created(Ingredients $ingredients): void
    {
        Log::create([
            'module' => 'tambah bahan',
            'action' => 'tambah bahan untuk id resep '.$ingredients->judul.' dengan id '.$ingredients->nama,
            'useraccess' => '-'
        ]);
    }

    /**
     * Handle the Ingredients "updated" event.
     */
    public function updated(Ingredients $ingredients): void
    {
        //
    }

    /**
     * Handle the Ingredients "deleted" event.
     */
    public function deleted(Ingredients $ingredients): void
    {
        //
    }

    /**
     * Handle the Ingredients "restored" event.
     */
    public function restored(Ingredients $ingredients): void
    {
        //
    }

    /**
     * Handle the Ingredients "force deleted" event.
     */
    public function forceDeleted(Ingredients $ingredients): void
    {
        //
    }
}
