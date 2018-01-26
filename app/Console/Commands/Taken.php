<?php

namespace App\Console\Commands;

use App\Taak;
use App\Werknemer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Taken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'takenlijst:taken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Haal de taken op.';

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
        setlocale(LC_ALL, 'nl_NL.utf8');
        $dag = ucfirst(Carbon::now()->formatLocalized('%A'));

        $taken = Taak::where('dag', $dag)->where('tijd', date('H:i'))->get();

        $this->getTaken($taken);
    }

    private function getTaken($taken)
    {
        foreach($taken as $index => $taak)
        {
            if(!$taak->werknemer_id) continue;

            $ids = explode(",", $taak->werknemer_id);
            $werknemers = array();

            foreach ($ids as $id)
            {
                array_push($werknemers, Werknemer::where('id', $id)->get());
            }

            if (sizeof($werknemers) > 0)
            {
                foreach ($werknemers as $werknemer)
                {
                    if ($werknemer[0]->naam == 'Iedereen')
                    {
                        $personen = Werknemer::where('naam', '!=', 'Iedereen')->get();
                        foreach ($personen as $persoon)
                        {
                            if($persoon->webhook == null) continue;

                            // Make your message
                            $message = array('payload' => json_encode(array('text' => 'Vergeet je taak niet! *' . $taak->taak . '*.')));

                            // Use curl to send your message
                            $c = curl_init($werknemer[0]->webhook);
                            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($c, CURLOPT_POST, true);
                            curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                            curl_exec($c);
                            curl_close($c);
                        }
                    }
                    else
                    {
                        if($werknemer[0]->webhook == null) continue;

                        // Make your message
                        $message = array('payload' => json_encode(array('text' => 'Vergeet je taak niet! *' . $taak->taak . '*.')));

                        // Use curl to send your message
                        $c = curl_init($werknemer[0]->webhook);
                        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($c, CURLOPT_POST, true);
                        curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                        curl_exec($c);
                        curl_close($c);
                    }
                }
            }
        }
    }
}
