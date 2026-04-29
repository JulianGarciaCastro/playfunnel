<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class PlayFunnelEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
* The content object instance.
*
* @var content
*/
    public $content;

    /**
* Create a new message instance.
*
* @return void
*/
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
* Build the message.
*
* @return $this
*/
    public function build()
    {
        return $this->view('mails.mail_template')
                     ->subject('Envio de Formulario')
                     ->from('info@playfunnel.net') //se puede pedir como parametro

                     //->attachFromStorage('Precios-AF-Corte.pdf','Precios'); //Si queremos adjuntar un archivo como PDF leera de storage
                    //->text('mails.demo_plain')
                    ;
    }
}
