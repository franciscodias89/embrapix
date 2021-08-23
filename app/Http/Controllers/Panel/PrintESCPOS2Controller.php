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
use Neodynamic\SDK\Web\Printer;

class PrintESCPOS2Controller extends Controller

{

    /**
     * ASCII null control character
     */
    const NUL = "\x00";

    /**
     * ASCII linefeed control character
     */
    const LF = "\x0a";

    /**
     * ASCII escape control character
     */
    const ESC = "\x1b";

    /**
     * ASCII form separator control character
     */
    const FS = "\x1c";

    /**
     * ASCII form feed control character
     */
    const FF = "\x0c";

    /**
     * ASCII group separator control character
     */
    const GS = "\x1d";

    /**
     * ASCII data link escape control character
     */
    const DLE = "\x10";

    /**
     * ASCII end of transmission control character
     */
    const EOT = "\x04";

    /**
     * Indicates UPC-A barcode when used with self::barcode
     */
    const BARCODE_UPCA = 65;

    /**
     * Indicates UPC-E barcode when used with self::barcode
     */
    const BARCODE_UPCE = 66;

    /**
     * Indicates JAN13 barcode when used with self::barcode
     */
    const BARCODE_JAN13 = 67;

    /**
     * Indicates JAN8 barcode when used with self::barcode
     */
    const BARCODE_JAN8 = 68;

    /**
     * Indicates CODE39 barcode when used with self::barcode
     */
    const BARCODE_CODE39 = 69;

    /**
     * Indicates ITF barcode when used with self::barcode
     */
    const BARCODE_ITF = 70;

    /**
     * Indicates CODABAR barcode when used with self::barcode
     */
    const BARCODE_CODABAR = 71;

    /**
     * Indicates CODE93 barcode when used with self::barcode
     */
    const BARCODE_CODE93 = 72;

    /**
     * Indicates CODE128 barcode when used with self::barcode
     */
    const BARCODE_CODE128 = 73;

    /**
     * Indicates that HRI (human-readable interpretation) text should not be
     * printed, when used with self::setBarcodeTextPosition
     */
    const BARCODE_TEXT_NONE = 0;

    /**
     * Indicates that HRI (human-readable interpretation) text should be printed
     * above a barcode, when used with self::setBarcodeTextPosition
     */
    const BARCODE_TEXT_ABOVE = 1;

    /**
     * Indicates that HRI (human-readable interpretation) text should be printed
     * below a barcode, when used with self::setBarcodeTextPosition
     */
    const BARCODE_TEXT_BELOW = 2;

    /**
     * Use the first color (usually black), when used with self::setColor
     */
    const COLOR_1 = 0;

    /**
     * Use the second color (usually red or blue), when used with self::setColor
     */
    const COLOR_2 = 1;

    /**
     * Make a full cut, when used with self::cut
     */
    const CUT_FULL = 65;

    /**
     * Make a partial cut, when used with self::cut
     */
    const CUT_PARTIAL = 66;

    /**
     * Use Font A, when used with self::setFont
     */
    const FONT_A = 0;

    /**
     * Use Font B, when used with self::setFont
     */
    const FONT_B = 1;

    /**
     * Use Font C, when used with self::setFont
     */
    const FONT_C = 2;

    /**
     * Use default (high density) image size, when used with self::graphics,
     * self::bitImage or self::bitImageColumnFormat
     */
    const IMG_DEFAULT = 0;

    /**
     * Use lower horizontal density for image printing, when used with self::graphics,
     * self::bitImage or self::bitImageColumnFormat
     */
    const IMG_DOUBLE_WIDTH = 1;

    /**
     * Use lower vertical density for image printing, when used with self::graphics,
     * self::bitImage or self::bitImageColumnFormat
     */
    const IMG_DOUBLE_HEIGHT = 2;

    /**
     * Align text to the left, when used with self::setJustification
     */
    const JUSTIFY_LEFT = 0;

    /**
     * Center text, when used with self::setJustification
     */
    const JUSTIFY_CENTER = 1;

    /**
     * Align text to the right, when used with self::setJustification
     */
    const JUSTIFY_RIGHT = 2;

    /**
     * Use Font A, when used with self::selectPrintMode
     */
    const MODE_FONT_A = 0;

    /**
     * Use Font B, when used with self::selectPrintMode
     */
    const MODE_FONT_B = 1;

    /**
     * Use text emphasis, when used with self::selectPrintMode
     */
    const MODE_EMPHASIZED = 8;

    /**
     * Use double height text, when used with self::selectPrintMode
     */
    const MODE_DOUBLE_HEIGHT = 16;

    /**
     * Use double width text, when used with self::selectPrintMode
     */
    const MODE_DOUBLE_WIDTH = 32;

    /**
     * Underline text, when used with self::selectPrintMode
     */
    const MODE_UNDERLINE = 128;

    /**
     * Indicates standard PDF417 code
     */
    const PDF417_STANDARD = 0;

    /**
     * Indicates truncated PDF417 code
     */
    const PDF417_TRUNCATED = 1;

    /**
     * Indicates error correction level L when used with self::qrCode
     */
    const QR_ECLEVEL_L = 0;

    /**
     * Indicates error correction level M when used with self::qrCode
     */
    const QR_ECLEVEL_M = 1;

    /**
     * Indicates error correction level Q when used with self::qrCode
     */
    const QR_ECLEVEL_Q = 2;

    /**
     * Indicates error correction level H when used with self::qrCode
     */
    const QR_ECLEVEL_H = 3;

    /**
     * Indicates QR model 1 when used with self::qrCode
     */
    const QR_MODEL_1 = 1;

    /**
     * Indicates QR model 2 when used with self::qrCode
     */
    const QR_MODEL_2 = 2;

    /**
     * Indicates micro QR code when used with self::qrCode
     */
    const QR_MICRO = 3;

    /**
     * Indicates a request for printer status when used with
     * self::getPrinterStatus (experimental)
     */
    const STATUS_PRINTER = 1;

    /**
     * Indicates a request for printer offline cause when used with
     * self::getPrinterStatus (experimental)
     */
    const STATUS_OFFLINE_CAUSE = 2;

    /**
     * Indicates a request for error cause when used with self::getPrinterStatus
     * (experimental)
     */
    const STATUS_ERROR_CAUSE = 3;

    /**
     * Indicates a request for error cause when used with self::getPrinterStatus
     * (experimental)
     */
    const STATUS_PAPER_ROLL = 4;

    /**
     * Indicates a request for ink A status when used with self::getPrinterStatus
     * (experimental)
     */
    const STATUS_INK_A = 7;

    /**
     * Indicates a request for ink B status when used with self::getPrinterStatus
     * (experimental)
     */
    const STATUS_INK_B = 6;

    /**
     * Indicates a request for peeler status when used with self::getPrinterStatus
     * (experimental)
     */
    const STATUS_PEELER = 8;

    /**
     * Indicates no underline when used with self::setUnderline
     */
    const UNDERLINE_NONE = 0;

    /**
     * Indicates single underline when used with self::setUnderline
     */
    const UNDERLINE_SINGLE = 1;

    /**
     * Indicates double underline when used with self::setUnderline
     */
    const UNDERLINE_DOUBLE = 2;


      /**
     * @var mixed
     */
    public $printer;
    /**
     * @var int
     */

    public function printCommands(Request $request){
        
        if ($request->exists(WebClientPrint::CLIENT_PRINT_JOB)) {
 
             //$useDefaultPrinter = ($request->input('useDefaultPrinter') === 'checked');
             //$printerName = urldecode($request->input('printerName'));
             $useDefaultPrinter = null;
             $order_id = urldecode($request->input('order_id'));
             $order = Order::where('id', $order_id)->with('restaurant', 'user', 'orderitems', 'orderitems.order_item_addons')->firstOrFail();
          
             $restaurant_id=$order->restaurant_id;
             $printerData=Restaurant::where('id',$restaurant_id)->first()->printer_data;
             $printer=json_decode($printerData,true);

             $printerName=$printer['printerName'];
        
             
             
            /*  //Create ESC/POS commands for sample receipt
             $esc = '0x1B'; //ESC byte in hex notation
             $newLine = '0x0A'; //LF byte in hex notation


          
             
             $cmds = '';
             $cmds = $esc . "@"; //Initializes the printer (ESC @)
             $cmds .= $esc . '!' . '0x38'; //Emphasized + Double-height + Double-width mode selected (ESC ! (8 + 16 + 32)) 56 dec => 38 hex
             $cmds .= 'COMPRA BAKANA';
             $cmds .= $newLine. $newLine;
             $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
             $cmds .= 'Loja:'.$order->restaurant->name;
          
             $cmds .= $newLine;
             $cmds .= 'Data:'. Carbon::parse($order->created_at);
          
             $cmds .= $newLine . $newLine;


             $cmds .= $this->drawLine(48);
             $cmds .= $newLine;
             $cmds .= 'Pedido: '.$order->unique_order_id;
      
             $cmds .= $newLine;
             if ($order->delivery_type == 1) {
                $cmds .= 'DELIVERY';
               
            } else {
                $cmds .= 'RETIRADA';
                
               
            }
            $cmds .= $newLine;
             $cmds .= $this->drawLine(48);
        
             $cmds .= $newLine . $newLine;
             $cmds .= 'SUBTOTAL                  8.78';
             $cmds .= $newLine;
             $cmds .= 'TAX 5%                    0.44';
             $cmds .= $newLine;
             $cmds .= 'TOTAL                     9.22';
             $cmds .= $newLine;
             $cmds .= 'CASH TEND                10.00';
             $cmds .= $newLine;
             $cmds .= 'CASH DUE                  0.78';
             $cmds .= $newLine . $newLine;
             $paid_cashbakana = $this->columnify('Pago com CashBakana', str_replace(".", ",", '0.85'), 75, 25, 0, 0, 48);
             $cmds .= $paid_cashbakana;
             $cmds .= $esc . '!' . '0x18'; //Emphasized + Double-height mode selected (ESC ! (16 + 8)) 24 dec => 18 hex
             $cmds .= '# ITEMS SOLD 2';
             $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
             $cmds .= $newLine . $newLine;
             $cmds .= '11/03/13  19:53:17';
 

           

             $store_name = $order->restaurant->name;
             $store_address = $order->restaurant->address;
             $order_id = $order->unique_order_id; */

                $adminSettings = PrinterSetting::where('user_id', '1')->first();
                $adminData = json_decode($adminSettings->data);
           

     
             $char_per_line=48;
             $store_name = $order->restaurant->name;
             $store_address = $order->restaurant->address;
             $order_id = $order->unique_order_id;
             $cmds ='';
             $cmds .= $this->setJustification(self::JUSTIFY_CENTER);
     
             if (!empty($adminData->invoice_title)) {
                 $cmds .= $this->feed();
                 $cmds .= $this->selectPrintMode(self::MODE_DOUBLE_WIDTH);
                 $cmds .= $this->text($adminData->invoice_title);
                 $cmds .= $this->selectPrintMode();
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->invoice_subtitle)) {
                 $cmds .= $this->selectPrintMode(self::MODE_FONT_B);
                 $cmds .= $this->text($adminData->invoice_subtitle);
                 $cmds .= $this->selectPrintMode();
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->invoice_title) || !empty($adminData->invoice_subtitle)) {
                 $cmds .= $this->text($this->drawLine($char_per_line));
             }
     
             $cmds .= $this->feed();
     
             if (!empty($adminData->show_store_name)) {
                 $cmds .= $this->setEmphasis(true);
                 $cmds .= $this->setUnderline(1);
                 $cmds .= $this->text($store_name);
                 $cmds .= $this->setUnderline(0);
                 $cmds .= $this->setEmphasis(false);
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_store_address)) {
                 $cmds .= $this->text($store_address);
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_order_id)) {
                 $cmds .= $this->text(!empty($adminData->order_id_label) ? $adminData->order_id_label . ' ' . $order_id : 'Pedido: ' . $order_id);
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_order_date)) {
                 $created_at = Carbon::parse($order->created_at);
                 $cmds .= $this->text(!empty($adminData->order_date_label) ? $adminData->order_date_label . ' ' . $created_at->format('d-m-Y H:i') : 'Data: ' . $created_at->format('d-m-Y H:i'));
                 $cmds .= $this->feed();
             }
             $cmds .= $this->feed();
             $cmds .= 'Canção Itambé';
             $cmds .= $this->feed();
     
             /* Customer Details */
             if (!empty($adminData->customer_details_title)) {
                 $cmds .= $this->setEmphasis(true);
                 $cmds .= $this->setUnderline(1);
                 $cmds .= $this->text($adminData->customer_details_title);
                 $cmds .= $this->setUnderline(0);
                 $cmds .= $this->setEmphasis(false);
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_customer_name)) {
                 $cmds .= $this->text($order->user->name);
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_customer_phone)) {
                 $cmds .= $this->text($order->user->phone);
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_delivery_type)) {
                 $cmds .= $this->setEmphasis(true);
                 //delivery order
                 if ($order->delivery_type == 1) {
                     $cmds .= $this->text(empty($adminData->delivery_label) ? 'DELIVERY' : $adminData->delivery_label);
                 } else {
                     //selfpickup order
                     $cmds .= $this->text(empty($adminData->selfpickup_label) ? 'RETIRADA' : $adminData->selfpickup_label);
                 }
                 $cmds .= $this->feed();
             }
     
             if (!empty($adminData->show_delivery_address) && $order->delivery_type == 1) {
                 $cmds .= $this->text($order->address);
                 $cmds .= $this->feed();
             }
     
             $cmds .= $this->setEmphasis(false);
             $cmds .= $this->feed();
     
           
             /* END Customer Details */
     
      /* Payment */
     
         $cmds .= $this->setEmphasis(true);
         $cmds .= $this->setUnderline(1);
         $cmds .= $this->text('Forma de Pagamento');
         $cmds .= $this->setUnderline(0);
         $cmds .= $this->setEmphasis(false);
         $cmds .= $this->feed();
     
         if ($order->payment_type == 'app') {
     
             if ($order->payment_mode == 'CREDITCARD') {
                 $cmds .= $this->text('Pagamento pelo APP');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'MULTIPLE') {
                 $cmds .= $this->text('Pagamento pelo APP');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'CASHBAKANA') {
                 $cmds .= $this->text('Pagamento pelo APP');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'CASHSTORE') {
                 $cmds .= $this->text('Pagamento pelo APP');
                 $cmds .= $this->feed();
             }
         }
     
         if ($order->payment_type == 'delivery') {
     
             if ($order->payment_mode == 'CREDITCARD') {
                 $cmds .= $this->text('Pagamento na Entrega (Cartão de Crédito)');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'DEBITCARD') {
                 $cmds .= $this->text('Pagamento na Entrega (Cartão de Débito)');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'PIX') {
                 $cmds .= $this->text('Pagamento na Entrega (PIX)');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'COD') {
                 $cmds .= $this->text('Pagamento na Entrega (Dinheiro)');
                 $cmds .= $this->feed();
             }
             if($order->cod_change != null){
                 $cmds .= $this->text('Troco para: R$'. str_replace(".", ",", $order->cod_change));
                 $cmds .= $this->feed();
             }
         }
     
         if ($order->payment_type == 'selfpickup') {
     
             if ($order->payment_mode == 'CREDITCARD') {
                 $cmds .= $this->text('Pagamento na Retirada (Cartão de Crédito)');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'DEBITCARD') {
                 $cmds .= $this->text('Pagamento na Retirada (Cartão de Débito)');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'PIX') {
                 $cmds .= $this->text('Pagamento na Retirada (PIX)');
                 $cmds .= $this->feed();
             }
             if ($order->payment_mode == 'COD') {
                 $cmds .= $this->text('Pagamento na Retirada (Dinheiro)');
                 $cmds .= $this->feed();
             }
             if($order->cod_change != null){
                 $cmds .= $this->text('Troco para: R$'. str_replace(".", ",", $order->cod_change));
                 $cmds .= $this->feed();
             }
         }
     
     
     
             /* Customer Details */
             if (!empty($order->order_comment)) {
                 $cmds .= $this->setEmphasis(true);
                 $cmds .= $this->setUnderline(1);
                 $cmds .= $this->text('Observações:');
                 $cmds .= $this->setUnderline(0);
                 $cmds .= $this->setEmphasis(false);
                 $cmds .= $this->feed();
             }
     
             if (!empty($order->order_comment)) {
                 $cmds .= $this->text($order->order_comment);
                 $cmds .= $this->feed();
             }
     
              $cmds .= $this->setEmphasis(false);
             $cmds .= $this->feed();
     
           
             /* END Customer Details */
     
     
     
     
     
             $cmds .= $this->setJustification();
     
             $cmds .= $this->setJustification(self::JUSTIFY_LEFT);
     
             //bill item header
             $cmds .= $this->text($this->drawLine($char_per_line));
             $string = $this->columnify($this->columnify($this->columnify(!empty($adminData->quantity_label) ? $adminData->quantity_label : 'QTD', ' ' . !empty($adminData->item_label) ? $adminData->item_label : 'ITENS', 12, 40, 0, 0, $char_per_line), !empty($adminData->price_label) ? $adminData->price_label : 'PREÇO', 55, 20, 0, 0, $char_per_line), ' ' . !empty($adminData->total_label) ? $adminData->total_label : 'TOTAL', 75, 25, 0, 0, $char_per_line);
             $cmds .= $this->setEmphasis(true);
             $cmds .= $this->text(rtrim($string));
             $cmds .= $this->feed();
             $cmds .= $this->setEmphasis(false);
             $cmds .= $this->text($this->drawLine($char_per_line));
     
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
     
                 // //print products/items
                 if ($orderItemAddons > 0) {
                     $string = rtrim($this->columnify($this->columnify($this->columnify($orderitem->quantity, $orderitem->name . ' (' . $orderitem->addon_name . ')', 12, 40, 0, 0, $char_per_line), str_replace(".", ",", $orderitem->price), 55, 20, 0, 0, $char_per_line), str_replace(".", ",", $itemTotal), 75, 25, 0, 0, $char_per_line));
                 } else {
                     $string = rtrim($this->columnify($this->columnify($this->columnify($orderitem->quantity, $orderitem->name, 12, 40, 0, 0, $char_per_line), str_replace(".", ",", $orderitem->price), 55, 20, 0, 0, $char_per_line), str_replace(".", ",", $itemTotal), 75, 25, 0, 0, $char_per_line));
                 }
     
                 $cmds .= $this->text($string);
                 $cmds .= $this->feed();
     
             }
     
             $cmds .= $this->feed();
             $cmds .= $this->text($this->drawLine($char_per_line));
     
             $cmds .= $this->setJustification(self::JUSTIFY_LEFT);
     
             //coupon
             if ($order->coupon_name != null) {
                 $coupon = $this->columnify($adminData->coupon_label . ' ', $order->coupon_name, 75, 25, 0, 0, $char_per_line);
                 $cmds .= $this->text(rtrim($coupon));
                 $cmds .= $this->feed();
             }
     
             //store charge
             $storeCharge = $this->columnify($adminData->store_charge_label . ' ',  str_replace(".", ",", (float) $order->restaurant_charge), 75, 25, 0, 0, $char_per_line);
             $cmds .= $this->text(rtrim($storeCharge));
             $cmds .= $this->feed();
     
             //delivery charge
             $deliveryCharge = $this->columnify($adminData->delivery_charge_label . ' ', str_replace(".", ",", $order->delivery_charge), 75, 25, 0, 0, $char_per_line);
             $cmds .= $this->text(rtrim($deliveryCharge));
             $cmds .= $this->feed();
     
             //Tax
             if ($order->tax != null) {
                 $tax = $this->columnify($adminData->tax_label . ' ', $order->tax . '%', 75, 25, 0, 0, $char_per_line);
                 $cmds .= $this->text(rtrim($tax));
                 $cmds .= $this->feed();
             }
     
             //Order Total
     
             $cmds .= $this->setJustification(self::JUSTIFY_CENTER);
             $cmds .= $this->text($this->drawLine($char_per_line));
             $cmds .= $this->setJustification();
     
             $orderTotal = $this->columnify($adminData->total_label . ' ', str_replace(".", ",", $order->total), 75, 25, 0, 0, $char_per_line);
             $cmds .= $this->setEmphasis(true);
             $cmds .= $this->text(rtrim($orderTotal));
             $cmds .= $this->setEmphasis(false);
             $cmds .= $this->feed();
     
             $cmds .= $this->setJustification();
     
             $cmds .= $this->setJustification(self::JUSTIFY_CENTER);
             $cmds .= $this->text($this->drawLine($char_per_line));
             $cmds .= $this->setJustification();
     
               //Payment
     
               
       
               $paid_cbkpay = $this->columnify('Pago pelo App', str_replace(".", ",", $order->paid_cbkpay), 75, 25, 0, 0, $char_per_line);
               $cmds .= $this->text(rtrim($paid_cbkpay));
               $cmds .= $this->feed();
     
               $paid_cashback_store = $this->columnify('Desconto CashBack da Loja', str_replace(".", ",", $order->paid_cashback_store), 75, 25, 0, 0, $char_per_line);
               $cmds .= $this->text(rtrim($paid_cashback_store));
               $cmds .= $this->feed();
     
               $paid_cashbakana = $this->columnify('Pago com CashBakana', str_replace(".", ",", $order->paid_cashbakana), 75, 25, 0, 0, $char_per_line);
               $cmds .= $this->text(rtrim($paid_cashbakana));
               $cmds .= $this->feed();
     
               $cmds .= $this->setJustification(self::JUSTIFY_CENTER);
               $cmds .= $this->text($this->drawLine($char_per_line));
               $cmds .= $this->setJustification();
     
               $payable = $this->columnify('A Pagar ', str_replace(".", ",", (float) $order->payable), 75, 25, 0, 0, $char_per_line);
               $cmds .= $this->setEmphasis(true);
               $cmds .= $this->text(rtrim($payable));
               $cmds .= $this->setEmphasis(false);
               $cmds .= $this->feed();
     
               $cmds .= $this->setJustification();
       
               $cmds .= $this->setJustification(self::JUSTIFY_CENTER);
               $cmds .= $this->text($this->drawLine($char_per_line));
               $cmds .= $this->setJustification();
     
             //admin footer
             if (!empty($adminData->footer_title)) {
                 $cmds .= $this->setJustification(self::JUSTIFY_CENTER);
                 $cmds .= $this->feed();
                 $cmds .= $this->setUnderline(1);
                 $cmds .= $this->text($adminData->footer_title);
                 $cmds .= $this->setUnderline(0);
                 $cmds .= $this->feed();
                 $cmds .= $this->setJustification();
             }
     
             if (!empty($adminData->footer_sub_title)) {
                 //break lines in new array
                 $subFooters = preg_split("/\r\n|\n|\r/", $adminData->footer_sub_title);
     
                 $cmds .= $this->setJustification(self::JUSTIFY_LEFT);
                 $cmds .= $this->feed();
                 foreach ($subFooters as $subFooter) {
                     $cmds .= $this->text($subFooter);
                     $cmds .= $this->feed();
                 }
                 $cmds .= $this->setJustification();
             }
     
             $cmds .= $this->feed();
     
             
     
             //cut receipt
             $cmds .= $this->cut();
     
     
               
             //cut receipt
           //  $cmds .= $this->cut();
     


         
             //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
             $cpj = new ClientPrintJob();
             //set ESCPOS commands to print...
             $cpj->printerCommands = $cmds;
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
     
     /**
     * Cut the paper.
     *
     * @param int $mode Cut mode, either self::CUT_FULL or self::CUT_PARTIAL. If not specified, `self::CUT_FULL` will be used.
     * @param int $lines Number of lines to feed
     */
    public function cut($mode = self::CUT_FULL, $lines = 3)
    {
        // TODO validation on cut() inputs
        return self::GS . "V" . chr($mode) . chr($lines);
    }
    
    /**
     * Print and feed line / Print and feed n lines.
     *
     * @param int $lines Number of lines to feed
     */
    public function feed($lines = 1)
    {
        self::validateInteger($lines, 1, 255, __FUNCTION__);
        if ($lines <= 1) {
            return self::LF;
        } else {
            return self::ESC . "d" . chr($lines);
        }
    }

 /**
     * Turn emphasized mode on/off.
     *
     *  @param boolean $on true for emphasis, false for no emphasis
     */
    public function setEmphasis($on = true)
    {
        self::validateBoolean($on, __FUNCTION__);
        return self::ESC . "E". ($on ? chr(1) : chr(0));
    }
    
    /**
     * Select font. Most printers have two fonts (Fonts A and B), and some have a third (Font C).
     *
     * @param int $font The font to use. Must be either self::FONT_A, self::FONT_B, or self::FONT_C.
     */
    public function setFont($font = self::FONT_A)
    {
        self::validateInteger($font, 0, 2, __FUNCTION__);
        return self::ESC . "M" . chr($font);
    }
    
    /**
     * Select justification.
     *
     * @param int $justification One of self::JUSTIFY_LEFT, self::JUSTIFY_CENTER, or self::JUSTIFY_RIGHT.
     */
    public function setJustification($justification = self::JUSTIFY_LEFT)
    {
        self::validateInteger($justification, 0, 2, __FUNCTION__);
        return self::ESC . "a" . chr($justification);
    }


        /**
     * Select print mode(s).
     *
     * Several MODE_* constants can be OR'd together passed to this function's `$mode` argument. The valid modes are:
     *  - self::MODE_FONT_A
     *  - self::MODE_FONT_B
     *  - self::MODE_EMPHASIZED
     *  - self::MODE_DOUBLE_HEIGHT
     *  - self::MODE_DOUBLE_WIDTH
     *  - self::MODE_UNDERLINE
     *
     * @param int $mode The mode to use. Default is self::MODE_FONT_A, with no special formatting. This has a similar effect to running initialize().
     */
    public function selectPrintMode($mode = self::MODE_FONT_A)
    {
        $allModes = self::MODE_FONT_B | self::MODE_EMPHASIZED | self::MODE_DOUBLE_HEIGHT | self::MODE_DOUBLE_WIDTH | self::MODE_UNDERLINE;
        if (!is_integer($mode) || $mode < 0 || ($mode & $allModes) != $mode) {
            throw new InvalidArgumentException("Invalid mode");
        }

        return self::ESC . "!" . chr($mode);
    }



/**
     * Set the size of text, as a multiple of the normal size.
     *
     * @param int $widthMultiplier Multiple of the regular height to use (range 1 - 8)
     * @param int $heightMultiplier Multiple of the regular height to use (range 1 - 8)
     */
    public function setTextSize($widthMultiplier, $heightMultiplier)
    {
        self::validateInteger($widthMultiplier, 1, 8, __FUNCTION__);
        self::validateInteger($heightMultiplier, 1, 8, __FUNCTION__);
        $c = pow(2, 4) * ($widthMultiplier - 1) + ($heightMultiplier - 1);
       return self::GS . "!" . chr($c);
    }

    /**
     * Set underline for printed text.
     *
     * Argument can be true/false, or one of UNDERLINE_NONE,
     * UNDERLINE_SINGLE or UNDERLINE_DOUBLE.
     *
     * @param int $underline Either true/false, or one of self::UNDERLINE_NONE, self::UNDERLINE_SINGLE or self::UNDERLINE_DOUBLE. Defaults to self::UNDERLINE_SINGLE.
     */
    public function setUnderline($underline = self::UNDERLINE_SINGLE)
    {
        /* Map true/false to underline constants */
        if ($underline === true) {
            $underline = self::UNDERLINE_SINGLE;
        } elseif ($underline === false) {
            $underline = self::UNDERLINE_NONE;
        }
        /* Set the underline */
        self::validateInteger($underline, 0, 2, __FUNCTION__);
       
        return self::ESC . "-" . chr($underline);
    }
    
    /**
     * Add text to the buffer.
     *
     * Text should either be followed by a line-break, or feed() should be called
     * after this to clear the print buffer.
     *
     * @param string $str Text to print
     */
    public function text($str = "")
    {
        self::validateString($str, __FUNCTION__);
        return (string)$str;
    }

        /**
     * Generate two characters for a number: In lower and higher parts, or more parts as needed.
     *
     * @param int $input Input number
     * @param int $length The number of bytes to output (1 - 4).
     */
    protected static function intLowHigh($input, $length)
    {
        $maxInput = (256 << ($length * 8) - 1);
        self::validateInteger($length, 1, 4, __FUNCTION__);
        self::validateInteger($input, 0, $maxInput, __FUNCTION__);
        $outp = "";
        for ($i = 0; $i < $length; $i++) {
            $outp .= chr($input % 256);
            $input = (int)($input / 256);
        }
        return $outp;
    }
    
    /**
     * Throw an exception if the argument given is not a boolean
     *
     * @param boolean $test the input to test
     * @param string $source the name of the function calling this
     */
    protected static function validateBoolean($test, $source)
    {
        if (!($test === true || $test === false)) {
            throw new InvalidArgumentException("Argument to $source must be a boolean");
        }
    }

    /**
     * Throw an exception if the argument given is not a float within the specified range
     *
     * @param float $test the input to test
     * @param float $min the minimum allowable value (inclusive)
     * @param float $max the maximum allowable value (inclusive)
     * @param string $source the name of the function calling this
     * @param string $argument the name of the invalid parameter
     */
    protected static function validateFloat($test, $min, $max, $source, $argument = "Argument")
    {
        if (!is_numeric($test)) {
            throw new InvalidArgumentException("$argument given to $source must be a float, but '$test' was given.");
        }
        if ($test < $min || $test > $max) {
            throw new InvalidArgumentException("$argument given to $source must be in range $min to $max, but $test was given.");
        }
    }

    /**
     * Throw an exception if the argument given is not an integer within the specified range
     *
     * @param int $test the input to test
     * @param int $min the minimum allowable value (inclusive)
     * @param int $max the maximum allowable value (inclusive)
     * @param string $source the name of the function calling this
     * @param string $argument the name of the invalid parameter
     */
    protected static function validateInteger($test, $min, $max, $source, $argument = "Argument")
    {
        self::validateIntegerMulti($test, [[$min, $max]], $source, $argument);
    }
    
    /**
     * Throw an exception if the argument given is not an integer within one of the specified ranges
     *
     * @param int $test the input to test
     * @param arrray $ranges array of two-item min/max ranges.
     * @param string $source the name of the function calling this
     * @param string $source the name of the function calling this
     * @param string $argument the name of the invalid parameter
     */
    protected static function validateIntegerMulti($test, array $ranges, $source, $argument = "Argument")
    {
        if (!is_integer($test)) {
            throw new InvalidArgumentException("$argument given to $source must be a number, but '$test' was given.");
        }
        $match = false;
        foreach ($ranges as $range) {
            $match |= $test >= $range[0] && $test <= $range[1];
        }
        if (!$match) {
            // Put together a good error "range 1-2 or 4-6"
            $rangeStr = "range ";
            for ($i = 0; $i < count($ranges); $i++) {
                $rangeStr .= $ranges[$i][0] . "-" . $ranges[$i][1];
                if ($i == count($ranges) - 1) {
                    continue;
                } elseif ($i == count($ranges) - 2) {
                    $rangeStr .= " or ";
                } else {
                    $rangeStr .= ", ";
                }
            }
            throw new InvalidArgumentException("$argument given to $source must be in $rangeStr, but $test was given.");
        }
    }

    /**
     * Throw an exception if the argument given can't be cast to a string
     *
     * @param string $test the input to test
     * @param string $source the name of the function calling this
     * @param string $argument the name of the parameter being validated
     * @throws InvalidArgumentException Where the argument is not valid
     */
    protected static function validateString($test, $source, $argument = "Argument")
    {
        if (is_object($test) && !method_exists($test, '__toString')) {
            throw new InvalidArgumentException("$argument to $source must be a string");
        }
    }
    
    /**
     * Throw an exception if the argument doesn't match the given regex.
     *
     * @param string $test the input to test
     * @param string $source the name of the function calling this
     * @param string $regex valid values for this attribute, as a regex
     * @param string $argument the name of the parameter being validated
     * @throws InvalidArgumentException Where the argument is not valid
     */
    protected static function validateStringRegex($test, $source, $regex, $argument = "Argument")
    {
        if (preg_match($regex, $test) === 0) {
            throw new InvalidArgumentException("$argument given to $source is invalid. It should match regex '$regex', but '$test' was given.");
        }
    }
}
