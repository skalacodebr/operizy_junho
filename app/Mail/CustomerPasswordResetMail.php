<?php

namespace App\Mail;

use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $slug;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $slug)
    {
        $this->token = $token;
        $this->slug = $slug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $store = Store::where('slug', $this->slug)->where('is_store_enabled', '1')->first();
        return $this->view('storefront.' . $store->theme_dir . '.auth.resetmail', ['token' => $this->token,'slug'=>$this->slug])->subject('Reset Password Notification');

    }
}
