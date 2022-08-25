<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewExpense extends Notification
{
    use Queueable;

    public $expense;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Expense $expense)
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
        $url = url('/expenses/'.$this->expense->id);
        $title = $this->expense->description;
        $amount = $this->expense->total;
        $name = $notifiable->fname;
        return (new MailMessage)
                    ->greeting('Hello '. $name.',')
                    ->subject('New Expense: '. $title)
                    ->line('You have an Expense Voucher requiring your attention.')
                    ->line('Name: '. $title)
                    ->line('Amount: N'. $amount)
                    ->action('View Voucher', $url)
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
