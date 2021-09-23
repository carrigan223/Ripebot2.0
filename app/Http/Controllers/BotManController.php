<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers;
use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{
 /**
  * Botman conversation logic
  */

 /** mockup of a client store object
  * temporary, will be replaced with dynamic
  * client data
  *
  */

 /**
  * variables to hold various user information
  */

//  protected $_firstname;
 //  protected $_email;
 //  protected $_phone;

 /**
  * this is the main function handling our incoming
  * post to the `/botman` route
  */

 public function handle()
 {

  $config = [
   //
  ];

  /**
   *Using Driver manager to access the webdriver
   *
   */
  Drivers\DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
  $botman = BotManFactory::create($config);
  Log::info("hello Andrew");


  /**
   * routeing through dialog flow middle ware 
   *
   */
  $dialogflow = \BotMan\Middleware\DialogFlow\V2\DialogFlow::create('en');
  $botman->middleware->received($dialogflow);
  Log::info("hello Andrew2");

  $botman->hears('(.*)', function ($botman) {
   $extras    = $botman->getMessage()->getExtras();
   $dfMessage = $botman->getMessage();
   Log::info(print_r($dfMessage, true));
   $botman->reply($extras['apiReply']);
  });

//   $botman->hears('hello', function ($botman) {
  //    $botman->reply("botman_blog_reavt");
  //   });

  $botman->listen();

 }

}
