<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lead;
use App\Mail\NewContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //la funzione da gestire è store dei dati provenienti dal form in front/axios
    public function store(Request $request){

        // prelevo i dati dal form
        $data = $request->all();

        // per la validazione dei dati mettiamo logica nostra, usiamo la funzione validator
        // PRIMO PARAMETRO: l'oggetto da validare
        // SECONDO PARAMETRO : Array con validazione come in $request->validate([...])
        $validator = Validator::make($data,
            [
                'name' => 'required',
                'email'=> 'required|email',
                'message'=> 'required|min:5',
            ]
        );

        // gestisco con validator così ho la possibilità di restituire un json con errori nel caso in cui la validazione on dovesse essere superata. Mi permette di stampare in front gli errori ricevuti in risposta con questo json
        // validator ha una funzione che restituisce un boolean true se fallisce la validazione, si chiama fails()
        // se fails, validazione non passa
        if($validator->fails()){
            // mi ritorni json errori
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors()
                ]
            );
        } else{
            //altrimenti mi salvi nel db il nuovo oggetto di tipo Lead (imposto in lead i fillable)
            $lead = new Lead();
            $lead->fill($data);
            $lead->save();

            // mandiamo mail a admin
            //PARAMETRO : email a cui inviare, potrebbe essere hardcoded come qui, ma più corretto di no, ad esempio impostata in .env e poi richiamata
            // Cosa deve inviare? una nuova istanza di NewContact che appunto vuole nel costruttore il parametro $lead, questo contiene tutte le info della persona che contatta e sono di conseguenza stampate nella view mail/newContact
            Mail::to('admin@boolpress.it')->send(new NewContact($lead));
            // Mail::to(env( 'ADMIN_MAIL'  ))->send(new NewContact($lead));

            //ritorna json positivo
            return response()->json(
                [
                    'success' => true,
                ]
            );

        }

    }
}
