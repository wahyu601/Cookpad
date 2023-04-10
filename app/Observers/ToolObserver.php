<?php

namespace App\Observers;

use App\Models\Tool;
use App\Models\Log;

class ToolObserver
{
    /**
     * Handle the Tool "created" event.
     */
    public function created(Tool $tool): void
    {
        Log::create([
            'module' => 'tambah alat',
            'action' => 'tambah alat untuk id resep '.$tool->resep_idresep.' dengan nama alat '.$tool->nama_alat,
            'useraccess' => '-' // kita bisa trace ini dari log module tambah resep
        ]);
    }

    /**
     * Handle the Tool "updated" event.
     */
    public function updated(Tool $tool): void
    {
        //
    }

    /**
     * Handle the Tool "deleted" event.
     */
    public function deleted(Tool $tool): void
    {
        //
    }

    /**
     * Handle the Tool "restored" event.
     */
    public function restored(Tool $tool): void
    {
        //
    }

    /**
     * Handle the Tool "force deleted" event.
     */
    public function forceDeleted(Tool $tool): void
    {
        //
    }
}
