<?php

namespace App\Services;

use Omnipay\Omnipay;


class Payment {

  private $gateway ;
  private $Error = null ;

  function __construct()
  {
    // Setup payment gateway
    $this->gateway = Omnipay::create('Stripe');
    $this->gateway->setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

    
  }

  function pay($card,$amount){

    $this->Error = null ; 

    // Example form data
    $date = explode("/", $card['date']) ;
    $cardData = [
      'number' => $card['cartNumber'],
      'expiryMonth' => $date[0],
      'expiryYear' => '20'.$date[1],
      'cvv' => $card['cvv']
    ];

      // Send purchase request
      $response = $this->gateway->purchase(
        [
            'amount' => $amount,
            'currency' => 'USD',
            'card' => $cardData
        ]
      )->send();

      // Process response
      if ($response->isSuccessful()) {

      } elseif ($response->isRedirect()) {
        
        // Redirect to offsite payment gateway
        $response->redirect();

      }else{
      // Payment failed
      $this->Error = $response->getMessage();
      }

  }

  function hasError(){
    return !is_null($this->Error) ;
  }

  function getError(){
    return $this->Error ;
  }
}