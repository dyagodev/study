<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReceivedTransfer extends Notification implements ShouldQueue
{
    use Queueable;

    const MAIL_SUCCESS = 'Success';

    protected $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        try {
            $response = Http::acceptJson()->get('http://o4d9z.mocklab.io/notify');
            $json = $response->json();

            if($response->status() == 200 && $json['message'] == self::MAIL_SUCCESS) {
                return (new MailMessage)
                    ->greeting('Olá! ' . $this->order->payee->name)
                    ->line('Você recebeu uma transferência de '. $this->order->payer->name .'.')
                    ->line('Valor: R$ ' .number_format($this->order->amount, 2, ',', '.'))
                    ->level('success')
                    ->action('Ver no App', url('/'))
                    ->line('Obrigado por usar o Pic Pay')
                    ->salutation('PicPay <3');
            }
            Log::alert('Unable to send email: ' . $json['message']);
        } catch (\Throwable $th) {
            Log::alert('Error sending transfer notification: '. $th->getMessage());
        }

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
