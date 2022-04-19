<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContact extends Mailable
{
    use Queueable, SerializesModels;
    // gestiamo la logica di creazione nuovo oggetto di tipo lead, questa classe NewContact ha attributo di tipo pucclico $lead, viena passato nel costruttore nel momento in cui creo un nuovo oggetto di NewContact
    public $lead; //ne definisco in basso il costruttore
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_lead)
    {
        $this->lead = $_lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //invia all'Admin una mail il cui layout va definito in una vista blade, creo cartella resources/views/email e dentro metto la mia vista
        return $this->view('email.newContact');
    }
}
