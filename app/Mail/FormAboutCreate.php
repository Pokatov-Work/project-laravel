<?php

namespace App\Mail;

use App\Models\forms\FormAbout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


/**
 * Отправка почты при сохранении формы обратной связи
 */
class FormAboutCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    /**
     * Create a new message instance.
     * @param FormAbout $form
     */
    public function __construct(FormAbout $form)
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
        return $this->subject('blockchaincapital.ru - Заполнена форма обратной связи')
            ->view('emails.about_form_create');
    }
}
