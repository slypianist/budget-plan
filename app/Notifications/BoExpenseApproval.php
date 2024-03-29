<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoExpenseApproval extends Notification
{
    use Queueable;
    public $expense;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($expense)
    {
        $this->expense = $expense;
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
        $url = url('/expense/'.$this->expense->id);
        $title = $this->expense->description;
        $amount = $this->expense->total;
        $name = $notifiable->fname;
        return (new MailMessage)
                    ->greeting('Hello '.$name.',')
                    ->subject('Budget Clear for: '.$title)
                    ->line('There is an expense voucher requiring your attention.')
                    ->line('Expense: '.$title)
                    ->line('Amount: '.$amount)
                    ->action('View voucher', $url)
                    ->line('Thank you for using our application!');
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
