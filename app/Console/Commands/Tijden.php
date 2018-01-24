<?php

namespace App\Console\Commands;

use App\Taak;
use Illuminate\Console\Command;

class Tijden extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'takenlijst:tijden';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geef elke taak een tijd.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $taken = Taak::get();

        $this->setTijden($taken);
    }

    private function setTijden($taken)
    {
        foreach($taken as $index => $taak)
        {
            switch ($taak->taak)
            {
                case 'Tafeldekken':
                    $taak->tijd = '11:55';
                    $taak->save();
                    break;

                case 'Vaatwasser uitruimen':
                    $taak->tijd = '09:15';
                    $taak->save();
                    break;

                case 'Afruimen':
                    $taak->tijd = '12:15';
                    $taak->save();
                    break;

                case 'Vaatwasser starten':
                    $taak->tijd = '17:15';
                    $taak->save();
                    break;

                case 'Vuilniszak legen':
                    $taak->tijd = '09:15';
                    $taak->save();
                    break;

                case 'Round check':
                    $taak->tijd = '17:15';
                    $taak->save();
                    break;

                case 'WC schoonmaken':
                    $taak->tijd = '17:15';
                    $taak->save();
                    break;

                case 'Vegen/dweilen of stofzuigen':
                    $taak->tijd = '17:15';
                    $taak->save();
                    break;

                case 'Koelkast schoonmaken':
                    $taak->tijd = '09:15';
                    $taak->save();
                    break;

                case 'Kastjesdeuren en aanrecht schoonmaken':
                    $taak->tijd = '17:15';
                    $taak->save();
                    break;

                case 'Bureau schoonmaken':
                    $taak->tijd = '17:15';
                    $taak->save();
                    break;
            }
        }
    }
}
