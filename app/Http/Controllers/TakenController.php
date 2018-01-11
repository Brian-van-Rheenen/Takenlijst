<?php

namespace App\Http\Controllers;

use App\Taak;
use App\Werknemer;
use Illuminate\Http\Request;

class TakenController extends Controller
{
    public function index()
    {
        $taken = Taak::get();
        $werknemers = Werknemer::get();

        return view('pages.takenlijst', compact('taken', 'werknemers'));
    }

    public function toevoegen()
    {
        $this->validate(request(), [
            'naam' => 'required'
        ]);

        $data = array_map('ucfirst', request(['naam']));

        $werknemer = Werknemer::create($data);

        return $werknemer;
    }

    public function opslaan()
    {
        $data = request('taken');
        Taak::truncate();

        foreach ($data as $dagen)
        {
            $dag = $dagen['dag'];

            foreach ($dagen as $taken)
            {
                if (gettype($taken) == 'array')
                {
                    for ($i=0; $i < sizeof($taken); $i++)
                    {
                        $taak = $taken[$i]['beschrijving'];
                        $werknemer_id = $taken[$i]['werknemer'];

                        $temp_data['dag'] = $dag;
                        $temp_data['taak'] = $taak;
                        $temp_data['werknemer_id'] = $werknemer_id;

                        Taak::create($temp_data);
                    }
                }
            }
        }
    }

    public function verwijder($id)
    {
        $werknemer = Werknemer::find($id);

        $werknemer->delete();
    }
}
