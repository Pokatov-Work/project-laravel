<?php


namespace App\Mail;

use App\Models\forms\FormCooperation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Отправка почты при сохранении формы обратной связи
 */
class FormCooperationCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    /**
     * Create a new message instance.
     * @param FormCooperation $form
     */
    public function __construct(FormCooperation $form)
    {
        $this->form = $form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('blockchaincapitals.ru - Заполнена форма обратной связи')
            ->view('emails.about_form_create');
    }
}
