<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\PlayFunnelEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{
     /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public $email;

    public function send()
    {
        $objDemo = new \stdClass();
        $objDemo->f_name = 'julian Horacio';
        $objDemo->tagf_name = 'First name';
        $objDemo->f_email = 'juliangaca@hotmail.com';
        $objDemo->tagf_email = 'Email';
        $objDemo->f_terms = 'on';
        $objDemo->tagf_terms = 'Accept Terms and Conditions';
        $objDemo->sendto = 'juliangaca@hotmail.com';
        $objDemo->nameForm = 'Formulario Test';

        Mail::to("juliangaca@hotmail.com")->send(new PlayFunnelEmail($objDemo));    }




    public function sendForm(Request $request)
    {

        $sendTo = $request->sendto;
        //Log::debug("----------------------------------------");
        //Log::debug($request);
        Log::debug("----------se envia a v2:------------------------------".$sendTo);
        //Log::debug("----------request------------------------------".json_decode($request));

      $response = Mail::mailer('smtp')
       ->to( $sendTo )
       //->queue(new PlayFunnelEmail('Julian Garcia')) //Envio programado **investigar
       ->send(new PlayFunnelEmail($request));

      return $response;
    }
}

