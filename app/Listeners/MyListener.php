<?php

namespace App\Listeners;

use App\Events\EncryptData;
use App\Safety\CryptageData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MyListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EncryptData  $event
     * @return void
     */
    public function handle(EncryptData $event)
    {
        $model = $event->model;

        // Crypter les attributs du modèle avant de les sauvegarder
        foreach ($model->getAttributes() as $key => $value) {
            $model->$key = CryptageData::datacrypt($value);
        }
    }
}
