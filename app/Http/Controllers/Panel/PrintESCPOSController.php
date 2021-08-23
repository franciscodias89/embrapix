<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Restaurant;
use Exception;
use InvalidArgumentException;
use App\Order;
use Illuminate\Http\Request;
use Session;
use Modules\ThermalPrinter\Entities\PrinterSetting;
use Auth;

//require_once(base_path('vendor\WebClientPrint\WebClientPrint.php'));
include_once(app_path() . '/WebClientPrint/WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\PrintFile;
use Neodynamic\SDK\Web\ClientPrintJob;
use Carbon\Carbon;
//use Neodynamic\SDK\Web\Printer;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\CapabilityProfile;


class PrintESCPOSController extends Controller

{

      /**
     * @var mixed
     */
    public $printer;
    /**
     * @var int
     */

    public function printCommands(Request $request){
        
        if ($request->exists(WebClientPrint::CLIENT_PRINT_JOB)) {

            $useDefaultPrinter = null;
            $order_id = urldecode($request->input('order_id'));
            $order = Order::where('id', $order_id)->with('restaurant', 'user', 'orderitems', 'orderitems.order_item_addons')->firstOrFail();
         
            $restaurant_id=$order->restaurant_id;
            $printerData=Restaurant::where('id',$restaurant_id)->first()->printer_data;
            $printer=json_decode($printerData,true);

            $printerName=$printer['printer_name'];

            
            $adminSettings = PrinterSetting::where('user_id', '1')->first();
            $adminData = json_decode($adminSettings->data);
       

 
         $char_per_line=48;
         $store_name = $order->restaurant->name;
         $store_address = $order->restaurant->address;
         $order_id = $order->unique_order_id;
 
                // Enter connector and capability profile (to match your printer)
    $connector = new DummyPrintConnector();
    $profile = CapabilityProfile::load("default");
    
    /* Print a series of receipts containing i18n example strings */
    $printer = new Printer($connector, $profile);
    $printer->setJustification(Printer::JUSTIFY_CENTER);

    if (!empty($adminData->invoice_title)) {
        $printer->feed();
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->text($adminData->invoice_title);
        $printer->selectPrintMode();
        $printer->feed();
    }

    if (!empty($adminData->invoice_subtitle)) {
        $printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->text($adminData->invoice_subtitle);
        $printer->selectPrintMode();
        $printer->feed();
    }

    if (!empty($adminData->invoice_title) || !empty($adminData->invoice_subtitle)) {
        $printer->text($this->drawLine($char_per_line));
    }

    $printer->feed();

    if (!empty($adminData->show_store_name)) {
        $printer->setEmphasis(true);
        $printer->setUnderline(1);
        $printer->text($store_name);
        $printer->setUnderline(0);
        $printer->setEmphasis(false);
        $printer->feed();
    }

    if (!empty($adminData->show_store_address)) {
        $printer->text($store_address);
        $printer->feed();
    }

    if (!empty($adminData->show_order_id)) {
        $printer->text(!empty($adminData->order_id_label) ? $adminData->order_id_label . ' ' . $order_id : 'Pedido: ' . $order_id);
        $printer->feed();
    }

    if (!empty($adminData->show_order_date)) {
        $created_at = Carbon::parse($order->created_at);
        $printer->text(!empty($adminData->order_date_label) ? $adminData->order_date_label . ' ' . $created_at->format('d-m-Y H:i') : 'Data: ' . $created_at->format('d-m-Y H:i'));
        $printer->feed();
    }

    $printer->feed();

    /* Customer Details */
    if (!empty($adminData->customer_details_title)) {
        $printer->setEmphasis(true);
        $printer->setUnderline(1);
        $printer->text($adminData->customer_details_title);
        $printer->setUnderline(0);
        $printer->setEmphasis(false);
        $printer->feed();
    }

    if (!empty($adminData->show_customer_name)) {
        $printer->text($order->user->name);
        $printer->feed();
    }

    if (!empty($adminData->show_customer_phone)) {
        $printer->text($order->user->phone);
        $printer->feed();
    }

    if (!empty($adminData->show_delivery_type)) {
        $printer->setEmphasis(true);
        //delivery order
        if ($order->delivery_type == 1) {
            $printer->text(empty($adminData->delivery_label) ? 'DELIVERY' : $adminData->delivery_label);
        } else {
            //selfpickup order
            $printer->text(empty($adminData->selfpickup_label) ? 'RETIRADA' : $adminData->selfpickup_label);
        }
        $printer->feed();
    }

    if (!empty($adminData->show_delivery_address) && $order->delivery_type == 1) {
        $printer->text($order->address);
        $printer->feed();
    }

    $printer->setEmphasis(false);
    $printer->feed();

  
    /* END Customer Details */

/* Payment */

$printer->setEmphasis(true);
$printer->setUnderline(1);
$printer->text('Forma de Pagamento');
$printer->setUnderline(0);
$printer->setEmphasis(false);
$printer->feed();

if ($order->payment_type == 'app') {

    if ($order->payment_mode == 'CREDITCARD') {
        $printer->text('Pagamento pelo APP');
        $printer->feed();
    }
    if ($order->payment_mode == 'MULTIPLE') {
        $printer->text('Pagamento pelo APP');
        $printer->feed();
    }
    if ($order->payment_mode == 'CASHBAKANA') {
        $printer->text('Pagamento pelo APP');
        $printer->feed();
    }
    if ($order->payment_mode == 'CASHSTORE') {
        $printer->text('Pagamento pelo APP');
        $printer->feed();
    }
}

if ($order->payment_type == 'delivery') {

    if ($order->payment_mode == 'CREDITCARD') {
        $printer->text('Pagamento na Entrega (Cartão de Crédito)');
        $printer->feed();
    }
    if ($order->payment_mode == 'DEBITCARD') {
        $printer->text('Pagamento na Entrega (Cartão de Débito)');
        $printer->feed();
    }
    if ($order->payment_mode == 'PIX') {
        $printer->text('Pagamento na Entrega (PIX)');
        $printer->feed();
    }
    if ($order->payment_mode == 'COD') {
        $printer->text('Pagamento na Entrega (Dinheiro)');
        $printer->feed();
    }
    if($order->cod_change != null){
        $printer->text('Troco para: R$'. str_replace(".", ",", $order->cod_change));
        $printer->feed();
    }
}

if ($order->payment_type == 'selfpickup') {

    if ($order->payment_mode == 'CREDITCARD') {
        $printer->text('Pagamento na Retirada (Cartão de Crédito)');
        $printer->feed();
    }
    if ($order->payment_mode == 'DEBITCARD') {
        $printer->text('Pagamento na Retirada (Cartão de Débito)');
        $printer->feed();
    }
    if ($order->payment_mode == 'PIX') {
        $printer->text('Pagamento na Retirada (PIX)');
        $printer->feed();
    }
    if ($order->payment_mode == 'COD') {
        $printer->text('Pagamento na Retirada (Dinheiro)');
        $printer->feed();
    }
    if($order->cod_change != null){
        $printer->text('Troco para: R$'. str_replace(".", ",", $order->cod_change));
        $printer->feed();
    }
}



    /* Customer Details */
    if (!empty($order->order_comment)) {
        $printer->setEmphasis(true);
        $printer->setUnderline(1);
        $printer->text('Observações:');
        $printer->setUnderline(0);
        $printer->setEmphasis(false);
        $printer->feed();
    }

    if (!empty($order->order_comment)) {
        $printer->text($order->order_comment);
        $printer->feed();
    }

     $printer->setEmphasis(false);
    $printer->feed();

  
    /* END Customer Details */





    $printer->setJustification();

    $printer->setJustification(Printer::JUSTIFY_LEFT);

    //bill item header
    $printer->text($this->drawLine($char_per_line));
    $string = $this->columnify($this->columnify($this->columnify(!empty($adminData->quantity_label) ? $adminData->quantity_label : 'QTD', ' ' . !empty($adminData->item_label) ? $adminData->item_label : 'ITENS', 12, 40, 0, 0, $char_per_line), !empty($adminData->price_label) ? $adminData->price_label : 'PREÇO', 55, 20, 0, 0, $char_per_line), ' ' . !empty($adminData->total_label) ? $adminData->total_label : 'TOTAL', 75, 25, 0, 0, $char_per_line);
    $printer->setEmphasis(true);
    $printer->text(rtrim($string));
    $printer->feed();
    $printer->setEmphasis(false);
    $printer->text($this->drawLine($char_per_line));

    foreach ($order->orderitems as $orderitem) {

        $itemTotal = ((float) $orderitem->price + (float) $this->calculateAddonTotal($orderitem->order_item_addons)) * $orderitem->quantity;

        //get addons and add to orderitem->addon_name
        $orderItemAddons = count($orderitem->order_item_addons);
        if ($orderItemAddons > 0) {
            $addons = '';
            foreach ($orderitem->order_item_addons as $addon) {
                $addons .= $addon->addon_name . ', ';
            }
            $addons = rtrim($addons, ', ');
            $orderitem->addon_name = $addons;
        }
        
        $string = rtrim($this->columnify($this->columnify($this->columnify($orderitem->quantity, $orderitem->name, 12, 40, 0, 0, $char_per_line), str_replace(".", ",", $orderitem->price), 55, 20, 0, 0, $char_per_line), str_replace(".", ",", $itemTotal), 75, 25, 0, 0, $char_per_line));
        $printer->text($string);
        $printer->feed(); 
       
             foreach ($orderitem->order_item_addons as $addon) {

                $string = rtrim($this->columnify($this->columnify(' ', $addon->addon_category_name . ': ' . $addon->addon_name . ')', 12, 40, 0, 0, $char_per_line), number_format($addon->addon_price,2,",","."), 55, 20, 0, 0, $char_per_line));
                $printer->text($string);
                $printer->feed();
               
            }
            
      
        

        

    }

    $printer->feed();
    $printer->text($this->drawLine($char_per_line));

    $printer->setJustification(Printer::JUSTIFY_LEFT);

    //coupon
    if ($order->coupon_name != null) {
        $coupon = $this->columnify($adminData->coupon_label . ' ', $order->coupon_name, 75, 25, 0, 0, $char_per_line);
        $printer->text(rtrim($coupon));
        $printer->feed();
    }

    //store charge
    $storeCharge = $this->columnify($adminData->store_charge_label . ' ',  number_format($order->restaurant_charge,2,",","."), 75, 25, 0, 0, $char_per_line);
    $printer->text(rtrim($storeCharge));
    $printer->feed();

    //delivery charge
    $deliveryCharge = $this->columnify($adminData->delivery_charge_label . ' ', str_replace(".", ",", $order->delivery_charge), 75, 25, 0, 0, $char_per_line);
    $printer->text(rtrim($deliveryCharge));
    $printer->feed();

    //Tax
    if ($order->tax != null) {
        $tax = $this->columnify($adminData->tax_label . ' ', $order->tax . '%', 75, 25, 0, 0, $char_per_line);
        $printer->text(rtrim($tax));
        $printer->feed();
    }

    //Order Total

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text($this->drawLine($char_per_line));
    $printer->setJustification();

    $orderTotal = $this->columnify($adminData->total_label . ' ', str_replace(".", ",", $order->total), 75, 25, 0, 0, $char_per_line);
    $printer->setEmphasis(true);
    $printer->text(rtrim($orderTotal));
    $printer->setEmphasis(false);
    $printer->feed();

    $printer->setJustification();

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text($this->drawLine($char_per_line));
    $printer->setJustification();

      //Payment

      

      $paid_cbkpay = $this->columnify('Pago pelo App', str_replace(".", ",", $order->paid_cbkpay), 75, 25, 0, 0, $char_per_line);
      $printer->text(rtrim($paid_cbkpay));
      $printer->feed();

      $paid_cashback_store = $this->columnify('Desconto CashBack da Loja', str_replace(".", ",", $order->paid_cashback_store), 75, 25, 0, 0, $char_per_line);
      $printer->text(rtrim($paid_cashback_store));
      $printer->feed();

      $paid_cashbakana = $this->columnify('Pago com CashBakana', str_replace(".", ",", $order->paid_cashbakana), 75, 25, 0, 0, $char_per_line);
      $printer->text(rtrim($paid_cashbakana));
      $printer->feed();

      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text($this->drawLine($char_per_line));
      $printer->setJustification();

      $payable = $this->columnify('A Pagar ', str_replace(".", ",", (float) $order->payable), 75, 25, 0, 0, $char_per_line);
      $printer->setEmphasis(true);
      $printer->text(rtrim($payable));
      $printer->setEmphasis(false);
      $printer->feed();

      $printer->setJustification();

      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text($this->drawLine($char_per_line));
      $printer->setJustification();

    //admin footer
    if (!empty($adminData->footer_title)) {
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed();
        $printer->setUnderline(1);
        $printer->text($adminData->footer_title);
        $printer->setUnderline(0);
        $printer->feed();
        $printer->setJustification();
    }

    if (!empty($adminData->footer_sub_title)) {
        //break lines in new array
        $subFooters = preg_split("/\r\n|\n|\r/", $adminData->footer_sub_title);

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed();
        foreach ($subFooters as $subFooter) {
            $printer->text($subFooter);
            $printer->feed();
        }
        $printer->setJustification();
    }

    $printer->feed();

   
    //cut receipt
    $printer->cut();

    $data = $connector -> getData();
    /* Close printer */
    $printer -> close();
               
             //cut receipt
           //  $cmds .= $this->cut();
     
           

         
             //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
             $cpj = new ClientPrintJob();
             //set ESCPOS commands to print...
             $cpj->printerCommands = $data;
             $cpj->formatHexValues = true;
             
            
             if ($useDefaultPrinter || $printerName === 'null') {
                $cpj->clientPrinter = new DefaultPrinter();
            } else {
                $cpj->clientPrinter = new InstalledPrinter($printerName);
            }
         
             //Send ClientPrintJob back to the client
             return response($cpj->sendToClient())
                         ->header('Content-Type', 'application/octet-stream');
                 
             
         }
     } 
     
      /**
     * @param $char_per_line
     * @return mixed
     */
    public function drawLine($char_per_line)
    {
        $new = '';
        for ($i = 1; $i < $char_per_line; $i++) {
            $new .= '-';
        }
        return $new . "\n";
    }

    /**
     * @param $addons
     * @return mixed
     */
    public function calculateAddonTotal($addons)
    {
        $total = 0;
        foreach ($addons as $addon) {
            $total += $addon->addon_price;
        }
        return $total;
    }

    /**
     * @param $leftCol
     * @param $rightCol
     * @param $leftWidthPercent
     * @param $rightWidthPercent
     * @param $space
     * @param $remove_for_space
     * @param $char_per_line
     */
    public function columnify($leftCol, $rightCol, $leftWidthPercent, $rightWidthPercent, $space = 2, $remove_for_space = 0, $char_per_line)
    {
        $char_per_line = $char_per_line - $remove_for_space;

        $leftWidth = $char_per_line * $leftWidthPercent / 100;
        $rightWidth = $char_per_line * $rightWidthPercent / 100;

        $leftWrapped = wordwrap($leftCol, $leftWidth, "\n", true);
        $rightWrapped = wordwrap($rightCol, $rightWidth, "\n", true);

        $leftLines = explode("\n", $leftWrapped);
        $rightLines = explode("\n", $rightWrapped);
        $allLines = array();
        for ($i = 0; $i < max(count($leftLines), count($rightLines)); $i++) {
            $leftPart = str_pad(isset($leftLines[$i]) ? $leftLines[$i] : '', $leftWidth, ' ');
            $rightPart = str_pad(isset($rightLines[$i]) ? $rightLines[$i] : '', $rightWidth, ' ');
            $allLines[] = $leftPart . str_repeat(' ', $space) . $rightPart;
        }
        return implode($allLines, "\n") . "\n";
    }
     
    
}
