<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class NewSubscription extends Notification implements ShouldQueue{
    use Queueable;

    protected $user;

    public function __construct(User $user){
        $this->user = $user;
        //
    }

    public function via($notifiable){
        return ['mail'];
    }

    public function toMail($notifiable){
       
        Log::debug('NewSubscription.toMail() Enviando correo a PF subscripcion de: ' . $this->user->email);
       
        return (new MailMessage)
                    ->subject('Nueva Suscripcion - ' . env('APP_ENV'))
                    ->line('Nueva subscripcion a PlayFunnel.')
                    ->line(' - Email: '  . $this->user->email)
                    ->line(' - Nombre: ' . $this->user->name)
                    ->line(' - SSO: '    . $this->user->google_id)
                    ->line('¡Vamos equipo!');
    }

    public function toWebhook($notifiable){
        return [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ];
    }

    public function toArray($notifiable){
        return [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ];
    }
}