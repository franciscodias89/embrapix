<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

//require_once(base_path('vendor\WebClientPrint\WebClientPrint.php'));
include_once(app_path() . '/WebClientPrint/WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;

class HomeController extends Controller
{
    public function index(){

        $wcppScript = WebClientPrint::createWcppDetectionScript(action('Panel\WebClientPrintController@processRequest'), Session::getId());    

        return view('home.index', ['wcppScript' => $wcppScript]);
    }

    public function printESCPOS(){
        $wcpScript = WebClientPrint::createScript(action('Panel\WebClientPrintController@processRequest'), action('Panel\PrintESCPOSController@printCommands'), Session::getId());    

        return view('home.printESCPOS', ['wcpScript' => $wcpScript]);
    }
     
}
