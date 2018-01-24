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
                // Create a constant to store your Slack URL
                if (!defined('SLACK_WEBHOOK')) define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');

                if (sizeof($werknemers) < 2)
                {
                    // Make your message
                    $message = array('payload' => json_encode(array('text' => '*' . $werknemers[0][0]->naam . '* moet: ' . $taak->taak . '.')));
                }
                else
                {
                    $namen = null;

                    foreach ($werknemers as $werknemer)
                    {
                        if($namen === null)
                        {
                            $namen = $werknemer[0]->naam;
                        }
                        else
                        {
                            if($werknemer == end($werknemers))
                            {
                                $namen = $namen . ' en ' . $werknemer[0]->naam;
                            }
                            else
                            {
                                $namen = $namen . ', ' . $werknemer[0]->naam;
                            }
                        }
                    }

                    // Make your message
                    $message = array('payload' => json_encode(array('text' => '*' . $namen . '* moeten: ' . $taak->taak . '.')));
                }

                // Use curl to send your message
                $c = curl_init(SLACK_WEBHOOK);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($c, CURLOPT_POST, true);
                curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                curl_exec($c);
                curl_close($c);
            }
        }
    }
}
