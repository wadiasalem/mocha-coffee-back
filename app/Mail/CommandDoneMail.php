<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandDoneMail extends Mailable
{
    use Queueable, SerializesModels;

    public $command ;
    public $client ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($command,$client)
    {
        $this->command = [] ;
        $this->client = $client;
        foreach ($command as $value) {
            $product = Product::find($value['product']);
            array_push($this->command,[
                'command'=>$value,
                'product'=>$product
            ]);
        }
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Command Passed')->markdown('mails.CommandsDone');
    }
}
