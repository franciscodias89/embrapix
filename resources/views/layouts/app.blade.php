
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
   dir="{{ (Session::get('layout')=='rtl' ? 'rtl' : 'ltr') }}">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      {{-- Title Section --}}
      <title> Compra Bakana - O Melhor App de Compras do Brasil
      </title>
      {{-- Meta Data --}}
      <meta name="description"
         content="@yield('page_description', $pageDescription ?? '')" />
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      {{-- Fonts --}}
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
      {{-- Inject:css, Global Theme Styles (used by all pages) --}}
      @include('layouts.partials._styles')
      {{-- Includable CSS --}}
      @yield('styles')
      {{-- Endinject --}}
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.png') }}">
   </head>
   <body class="layout-light side-menu @auth() overlayScroll @endauth">
      @auth()
      <div class="mobile-search"></div>
      <div class="mobile-author-actions"></div>
      @include('layouts.partials._header')
      @endauth
      <main class="main-content">
         @auth()
            @include('layouts.partials._aside')
         @endauth
         @section('content')
         @show
         @auth()
            @include('layouts.partials._footer')
         @endauth

         <input type="hidden" value="{{ csrf_token() }}" class="csrfToken">
<div id="newOrderModal" class="modal fade mt-5" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title mt-3"> <i class="fas fa-bell animated-bell"></i> </h5>
            </div>
            <div class="float-right pr-3 pt-3" style="position: absolute; right: 0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="newOrdersData">
                <div class="d-flex justify-content-center">
                    <h3 class="text-muted"> {{__('storeDashboard.dashboardNoOrders')}} </h3>
                </div>
            </div>
        </div>
    </div>
</div>




      </main>
      @auth()
      <div id="overlayer">
         <span class="loader-overlay">
            <div class="atbd-spin-dots spin-lg">
               <span class="spin-dot badge-dot dot-primary"></span>
               <span class="spin-dot badge-dot dot-primary"></span>
               <span class="spin-dot badge-dot dot-primary"></span>
               <span class="spin-dot badge-dot dot-primary"></span>
            </div>
         </span>
      </div>
      @include('layouts.partials._customizer')
      @endauth
      <div class="overlay-dark-sidebar"></div>
      <div class="customizer-overlay"></div>
      {{-- Inject:js, Global Theme JS Bundle (used by all pages) --}}
      @yield('mapScript')
      @include('layouts.partials._scripts')
      @include('admin.includes.notification')
      {{-- Includable JS --}}
      @yield('scripts')
      {{-- Endinject --}}

      <script>
         
         $(function() {

            var newOrderJson='';
            var newOrdersIds='';
            $.ajax({
                     url: '{{ route('restaurant.newOrdersNotification') }}',
                     type: 'POST',
                     dataType: 'json',
                     data: {_token: $('.csrfToken').val()},
                     success: function(data) {
                        useReturnData(data);
                        }
                 })
                 .done(function(data) {
                    //console.log(data)
                    
                     
                 })
                 .fail(function() {
                     console.log("error");
                 }) 

                 function useReturnData(data){
                    newOrderJson = data;
    //console.log(myvar);
                    };
       
                 $.ajax({
                     url: '{{ route('restaurant.newOrdersIdsNotification') }}',
                     type: 'POST',
                     dataType: 'json',
                     data: {_token: $('.csrfToken').val()},
                     success: function(data) {
                        useReturnData2(data);
                        },
                 })
                 .done(function(data) {
                     //newOrdersIds = data;
                 })
                 .fail(function() {
                     console.log("error");
                 }) 

                 function useReturnData2(data){
                    newOrdersIds = data;
    //console.log(myvar);
                    };


             var touchtime = 0;
             
             let notification = document.createElement('audio');
             let notificationFileRoute = 'https://app.comprabakana.com.br/assets/backend/tones/{{ config('settings.restaurantNotificationAudioTrack') }}.mp3';
                notification.setAttribute('src', notificationFileRoute);
                notification.setAttribute('type', 'audio/mp3');
                // notification.setAttribute('muted', 'muted');
                notification.setAttribute('loop', 'true');
             
             $(".stopSound").click(function(event) {
                 notification.pause();
                 notification.currentTime = 0;
             });
             
             
             
       
       
           
             
             console.log(newOrderJson);
         
             setInterval(function() {
                 $.ajax({
                     url: '{{ route('restaurant.getNewOrders') }}',
                     type: 'POST',
                     dataType: 'json',
                     data: {listed_order_ids: newOrdersIds, _token: $('.csrfToken').val()},
                 })
         
                 .done(function(newArray) {
                     console.log("New Array", newArray)
                     console.log(newOrderJson.length);
                     console.log(newArray.length );
         
                     if (newArray.length > 0) {
                         //if new orders, then lenght will be greater, if order cancelled, then it should not go inside this 
                         console.log("NEW ORDER")
                     
                         $('#newOrderModal').modal({
                             backdrop: 'static',
                             keyboard: false
                         });
         
                         //play sound
                         notification.play();
         
                         console.log("New Array", newArray)
                         // const newOrder = newArray[0];
         
                         let newOrderData = "";
                         $.map(newArray, function(order, index) {
                             if(order.delivery_type == 2) {
                                 var selfPickup = '<span class="badge badge-flat border-danger-800 text-default text-capitalize ml-1">{{__('storeDashboard.dashboardSelfPickup')}}</span>'
                             } else {
                                 selfPickup = "";
                             }
         
                             let viewOrderURL = "{{ url('/store-owner/order') }}/" + order.unique_order_id;
                             
                             console.log(order);
       
                             if (order.tip_amount != null) {
                                 var orderTotal = parseFloat(order.total) - parseFloat(order.tip_amount); 
                             } else {
                                  var orderTotal = order.total;
                             }
                             newOrderData +='<div class="popup-order mb-3"><div class="text-center my-3 h5"><strong>Novo Pedido - <i class="icon-arrow-right5"></i> <a class="stopSound" href="'+viewOrderURL+'">'+order.unique_order_id+'</a> </strong> </div>';
         
                             newOrderData += '<div class="d-flex justify-content-center"><a class="btn btn-primary btn-labeled btn-labeled-left mr-2 stopSound" href="'+viewOrderURL+'">Ver Pedido</a>    </div></div>'
                             
         
                             $('#newOrdersData').html(newOrderData);
                             $('#newOrdersNoOrdersMessage').remove();
                         });
                         
                     } else {
                         console.log("NO New Order")
                         //when orde has been accepted or denied, length will be 0, close the model
                         $('#newOrderModal').modal('hide');
                     }
                 })
                 .fail(function() {
                     console.log("error");
                 })  
             }, {{ config("settings.restaurantNewOrderRefreshRate") }} * 1000); //all API every x seconds (config settings from admin)
             
             //reload page when popup closed
             $('#newOrderModal').on('hidden.bs.modal', function () {
                 window.location.reload();
             })
         
         
             //on single click, accpet order and disable block
             $('body').on("click", ".acceptOrderBtn", function(e) {
                 
                 let context = $(this).parents('.popup-order');
                 context.addClass('popup-order-processing').prepend('<div class="d-flex pt-2 pr-2 float-right"><i class="icon-spinner10 spinner"></i></div>')
                 console.log("HERE", context);
         
                 let id = $(this).attr("data-id");
                 let acceptOrderUrl = "{{ url('/store-owner/orders/accept-order') }}/" +id;
                 $.ajax({
                     url: acceptOrderUrl,
                     type: 'GET',
                     dataType: 'JSON',
                 })
                 .done(function(data) {
                     $(context).remove();
                     //count number of order on popup, if 0 then remove popup
                     if ($('.popup-order').length == 0) {
                         $('#newOrderModal').modal('hide');
                     }
                     $.jGrowl("{{__('storeDashboard.orderAcceptedNotification')}}", {
                         position: 'bottom-center',
                         header: '{{__('storeDashboard.successNotification')}}',
                         theme: 'bg-success',
                         life: '5000'
                     });
                 })
                 .fail(function() {
                     console.log("error")
                     $.jGrowl("{{__('storeDashboard.orderSomethingWentWrongNotification')}}", {
                         position: 'bottom-center',
                         header: '{{__('storeDashboard.woopssNotification')}}',
                         theme: 'bg-warning',
                         life: '5000'
                     });
                 })
             });
             
             $('body').on("click", ".accpetOrderBtnTableList", function(e) {
                 $(this).parents('.new-order-actions').addClass('popup-order-processing');
             });
         
             //on Single click donot cancel order table list
             $('body').on("click", ".cancelOrderBtnTableList", function(e) {
                 return false;
             });
         
             $('body').on("click", ".cancelOrderBtnTableList", function(e) {
                 e.preventDefault()
                 if (((new Date().getTime()) - touchtime) < 500) {
                     $(this).parents('.new-order-actions').addClass('popup-order-processing');
                     window.location = this.href;
                     return false;
                 }
                 touchtime = new Date().getTime();
             });
         
             //on Single click donot cancel order popup
             $('body').on("click", ".cancelOrderBtnPopup", function(e) {
                 return false;
             });
             
             $('.actionAfterAccept').click(function(event) {
               $(this).parents('.accepted-order-actions').addClass('popup-order-processing');
             });
             
         
             $('body').on("click", ".cancelOrderBtnPopup", function(e) {
                 e.preventDefault()
         
                 if (((new Date().getTime()) - touchtime) < 500) {
         
                     let context = $(this).parents('.popup-order');
                     context.addClass('popup-order-processing').prepend('<div class="d-flex pt-2 pr-2 float-right"><i class="icon-spinner10 spinner"></i></div>')
                     console.log("HERE", context);
                     
                     let id = $(this).attr("data-id");
                     let cancelOrderURL = "{{ url('/store-owner/orders/cancel-order') }}/" +id;
                     $.ajax({
                         url: cancelOrderURL,
                         type: 'GET',
                         dataType: 'JSON',
                     })
                     .done(function(data) {
                         $(context).remove();
                         //count number of order on popup, if 0 then remove popup
                         if ($('.popup-order').length == 0) {
                             $('#newOrderModal').modal('hide');
                         }
                         $.jGrowl("{{__('storeDashboard.orderCanceledNotification')}}", {
                             position: 'bottom-center',
                             header: '{{__('storeDashboard.successNotification')}}',
                             theme: 'bg-success',
                             life: '5000'
                         });
                     })
                     .fail(function() {
                         console.log("error");
                         $.jGrowl("{{__('storeDashboard.orderSomethingWentWrongNotification')}}", {
                             position: 'bottom-center',
                             header: '{{__('storeDashboard.woopssNotification')}}',
                             theme: 'bg-warning',
                             life: '5000'
                         });
                     })
                 }
                 touchtime = new Date().getTime();
             });
         });
       </script>





   </body>
</html>