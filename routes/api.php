<?php

use Illuminate\Http\Request;

/* API ROUTES */
Route::post('/general-informations', [
    'uses' => 'Api\GeneralInformationsController@GeneralInformations',
])->middleware('log.route');

Route::post('/get-home-data', [
    'uses' => 'Api\RestaurantController@getHomeData',
])->middleware('log.route');

Route::post('/get-restaurant-another-data', [
    'uses' => 'Api\RestaurantController@anotherRestaurantData',
])->middleware('log.route');

Route::post('/get-all-restaurants', [
    'uses' => 'Api\RestaurantController@getAllRestaurants',
])->middleware('log.route');


Route::post('/get-all-cashbacks', [
    'uses' => 'Api\CashbackController@getAllCashBacks',
])->middleware('log.route');

Route::post('/get-cashback-amount-user', [
    'uses' => 'Api\CashbackController@getCashBackAmountUser',
])->middleware('log.route');

Route::post('/get-all-offers', [
    'uses' => 'Api\OffersController@getAllOffers',
])->middleware('log.route');

Route::post('/get-all-flyers-v2', [
    'uses' => 'Api\FlyerController@getAllFlyers',
])->middleware('log.route');

Route::post('/get-all-coupons-v2', [
    'uses' => 'Api\CouponController@getAllCoupons',
])->middleware('log.route');

Route::post('/get-all-sorteios', [
    'uses' => 'Api\SorteioController@getAllSorteios',
])->middleware('log.route');

Route::post('/get-all-restaurant-sorteios', [
    'uses' => 'Api\SorteioController@getAllRestaurantSorteios',
])->middleware('log.route');

Route::post('/get-free-shipping-restaurants', [
    'uses' => 'Api\RestaurantController@getfreeShippingRestaurants',
])->middleware('log.route');


Route::post('/send-restaurant-recommend', [
    'uses' => 'Api\RestaurantController@sendRestaurantReccomend',
])->middleware('log.route');
Route::post('/send-restaurant-apply', [
    'uses' => 'Api\RestaurantController@sendRestaurantApply',
])->middleware('log.route');

Route::post('/get-coupons-by-restaurant-id', [
    'uses' => 'Api\CouponController@getCouponsBYRestaurantID',
])->middleware('log.route');

Route::post('/check-cart-items-availability', [
    'uses' => 'Api\OrderController@checkCartItemsAvailability',
])->middleware('log.route');


Route::post('/coordinate-to-address', [
    'uses' => 'GeocoderController@coordinatesToAddress',
])->middleware('log.route');

Route::post('/address-to-coordinate', [
    'uses' => 'GeocoderController@addressToCoordinates',
])->middleware('log.route');

Route::post('/get-settings', [
    'uses' => 'SettingController@getSettings',
])->middleware('log.route');

//  to get tip amount list in cart page
Route::get('/get-setting/{key}', [
    'uses' => 'SettingController@getSettingByKey',
])->middleware('log.route');

Route::post('/search-location/{query}', [
    'uses' => 'LocationController@searchLocation',
])->middleware('log.route');

Route::post('/popular-locations', [
    'uses' => 'LocationController@popularLocations',
])->middleware('log.route');

Route::post('/popular-geo-locations', [
    'uses' => 'LocationController@popularGeoLocations',
])->middleware('log.route');

Route::post('/promo-slider', [
    'uses' => 'PromoSliderController@promoSlider',
])->middleware('log.route');

Route::post('/get-delivery-restaurants', [
    'uses' => 'RestaurantController@getDeliveryRestaurants',
])->middleware('log.route');

Route::post('/get-selfpickup-restaurants', [
    'uses' => 'RestaurantController@getSelfPickupRestaurants',
])->middleware('log.route');

Route::post('/get-restaurant-info/{slug}', [
    'uses' => 'RestaurantController@getRestaurantInfo',
])->middleware('log.route');

// Route::post('/get-restaurant-info-by-id/{id}', [
//     'uses' => 'RestaurantController@getRestaurantInfoById',
// ]);

Route::post('/get-restaurant-info-by-id', [
    'uses' => 'RestaurantController@getRestaurantInfoById',
])->middleware('log.route');

Route::post('/get-restaurant-info-and-operational-status', [
    'uses' => 'RestaurantController@getRestaurantInfoAndOperationalStatus',
])->middleware('log.route');

Route::post('/get-restaurant-items/{slug}', [
    'uses' => 'RestaurantController@getRestaurantItems',
])->middleware('log.route');
Route::post('/get-restaurant-items_by_category', [
    'uses' => 'RestaurantController@getRestaurantItemsBYCategory',
])->middleware('log.route');

Route::post('/get-restaurant-items_by_subcategory', [
    'uses' => 'RestaurantController@getRestaurantItemsBYSubCategory',
])->middleware('log.route');

Route::post('/get-restaurant-offers-by-category', [
    'uses' => 'RestaurantController@getRestaurantOffersBYCategory',
])->middleware('log.route');

Route::post('/get-restaurant-offers-by-subcategory', [
    'uses' => 'RestaurantController@getRestaurantOffersBYSubCategory',
])->middleware('log.route');

Route::post('/get-restaurant-flyers', [
    'uses' => 'RestaurantController@getFlyersBYRestaurant',
])->middleware('log.route');

Route::post('/get-all-flyers', [
    'uses' => 'RestaurantController@getAllFlyers',
])->middleware('log.route');

Route::post('/get-offers-by-store/{slug}', [
    'uses' => 'RestaurantController@getOffersBYstore',
])->middleware('log.route');

Route::post('/get-pages', [
    'uses' => 'PageController@getPages',
])->middleware('log.route');

Route::post('/get-single-page', [
    'uses' => 'PageController@getSinglePage',
])->middleware('log.route');

Route::post('/search-restaurants', [
    'uses' => 'RestaurantController@searchRestaurants',
])->middleware('log.route');

Route::post('/search-products-by-restaurants', [
    'uses' => 'RestaurantController@searchProductsBYRestaurants',
])->middleware('log.route');

Route::post('/send-otp', [
    'uses' => 'SmsController@sendOtp',
])->middleware('log.route');
Route::post('/verify-otp', [
    'uses' => 'SmsController@verifyOtp',
])->middleware('log.route');
Route::post('/check-restaurant-operation-service', [
    'uses' => 'RestaurantController@checkRestaurantOperationService',
])->middleware('log.route');

Route::post('/get-single-item', [
    'uses' => 'RestaurantController@getSingleItem',
])->middleware('log.route');

Route::post('/get-all-languages', [
    'uses' => 'LanguageController@getAllLanguages',
])->middleware('log.route');

Route::post('/get-single-language', [
    'uses' => 'LanguageController@getSingleLanguage',
])->middleware('log.route');

Route::post('/get-restaurant-category-slides', [
    'uses' => 'RestaurantCategoryController@getRestaurantCategorySlider',
])->middleware('log.route');

Route::post('/get-all-restaurants-categories', [
    'uses' => 'RestaurantCategoryController@getAllRestaurantsCategories',
])->middleware('log.route');

//ACR
Route::post('/get-all-restaurants-by-category', [
    'uses' => 'RestaurantController@getAllRestaurantsByCategory',
])->middleware('log.route');//-ACR

Route::post('/get-filtered-restaurants', [
    'uses' => 'RestaurantController@getFilteredRestaurants',
])->middleware('log.route');

Route::post('/send-password-reset-mail', [
    'uses' => 'PasswordResetController@sendPasswordResetMail',
])->middleware('log.route');

Route::post('/verify-password-reset-otp', [
    'uses' => 'PasswordResetController@verifyPasswordResetOtp',
])->middleware('log.route');

Route::post('/change-user-password', [
    'uses' => 'PasswordResetController@changeUserPassword',
])->middleware('log.route');



Route::get('/stripe-redirect-capture', [
    'uses' => 'PaymentController@stripeRedirectCapture',
])->name('stripeRedirectCapture');

/* Paytm */
Route::get('/payment/paytm/{order_id}', [
    'uses' => 'PaymentController@payWithPaytm',
])->middleware('log.route');
Route::post('/payment/process-paytm', [
    'uses' => 'PaymentController@processPaytm',
])->middleware('log.route');
/* END Paytm */

Route::post('/get-all-coupons', [
    'uses' => 'CouponController@getAllCoupons',
])->middleware('log.route');


Route::post('/store-general-informations', [
    'uses' => 'ApiLojista\GeneralInformationsController@GeneralInformations',
])->middleware('log.route');

Route::post('/delivery/general-informations', [
    'uses' => 'ApiEntregador\GeneralInformationsController@GeneralInformations',
])->middleware('log.route');

Route::post('/store-register', [
    'uses' => 'RegisterController@registerRestaurantDelivery',
])->middleware('log.route');


Route::post('/safe2pay-a10960ad-60c0-46e1-b0ad-2b1a59c6cb36', [
    'uses' => 'Webhooks\WebhooksController@webhookTransactionSafe2pay',
])->middleware('log.route');





/* Protected Routes for Loggedin users */
Route::group(['middleware' => ['jwt.auth']], function () {

    Route::post('/store-get-restaurant-data', [
        'uses' => 'ApiLojista\RestaurantController@getRestaurantData',
    ])->middleware('log.route');

    Route::post('/store-get-restaurant-items', [
        'uses' => 'ApiLojista\ItemController@getRestaurantItems',
    ])->middleware('log.route');

    Route::post('/store-update-item', [
        'uses' => 'ApiLojista\ItemController@updateItem',
    ])->middleware('log.route');

    Route::post('/store-create-item', [
        'uses' => 'ApiLojista\ItemController@saveNewItem',
    ])->middleware('log.route');

    Route::post('/store-search-item', [
        'uses' => 'ApiLojista\ItemController@searchProductsBYRestaurants',
    ])->middleware('log.route');

    Route::get('/store-update-wizard1', [
        'uses' => 'Wizard\WizardController@updateWizard1',
    ])->middleware('log.route');

    Route::get('/store-update-wizard2', [
        'uses' => 'Wizard\WizardController@updateWizard2',
    ])->middleware('log.route');

    Route::get('/store-update-wizard3', [
        'uses' => 'Wizard\WizardController@updateWizard3',
    ])->middleware('log.route');

    Route::get('/store-update-wizard4', [
        'uses' => 'Wizard\WizardController@updateWizard4',
    ])->middleware('log.route');
    
    Route::get('/store-update-wizard4_1', [
        'uses' => 'Wizard\WizardController@updateWizard4_1',
    ])->middleware('log.route');

    Route::get('/store-update-wizard4_2', [
        'uses' => 'Wizard\WizardController@updateWizard4_2',
    ])->middleware('log.route');

    Route::get('/store-update-wizard4_3', [
        'uses' => 'Wizard\WizardController@updateWizard4_3',
    ])->middleware('log.route');

    Route::get('/store-update-wizard5', [
        'uses' => 'Wizard\WizardController@updateWizard5',
    ])->middleware('log.route');

    Route::get('/store-update-wizard6', [
        'uses' => 'Wizard\WizardController@updateWizard6',
    ])->middleware('log.route');

    Route::get('/store-update-wizard7', [
        'uses' => 'Wizard\WizardController@updateWizard7',
    ])->middleware('log.route');

    Route::get('/store-update-wizard8', [
        'uses' => 'Wizard\WizardController@updateWizard8',
    ])->middleware('log.route');

    Route::post('/store-get-orders', [
        'uses' => 'ApiLojista\OrderController@getOrders',
    ])->middleware('log.route');

    Route::post('/store-order-details', [
        'uses' => 'ApiLojista\OrderController@OrderDetails',
    ])->middleware('log.route');

    Route::post('/store-accept-order', [
        'uses' => 'ApiLojista\OrderController@acceptOrder',
    ])->middleware('log.route');

    Route::post('/store-cancel-order', [
        'uses' => 'ApiLojista\OrderController@cancelOrder',
    ])->middleware('log.route');

    Route::post('/store-mark-order-ready-for-selfpickup', [
        'uses' => 'ApiLojista\OrderController@markOrderReady',
    ])->middleware('log.route');

    Route::post('/store-mark-order-selfpickup-as-completed', [
        'uses' => 'ApiLojista\OrderController@markSelfPickupOrderAsCompleted',
    ])->middleware('log.route');

    Route::post('/store-mark-order-as-onway', [
        'uses' => 'ApiLojista\OrderController@markOrderAsOnway',
    ])->middleware('log.route');

    Route::post('/store-mark-order-as-delivered', [
        'uses' => 'ApiLojista\OrderController@markOrderAsDelivered',
    ])->middleware('log.route');

    Route::post('/separator/order-details', [
        'uses' => 'ApiSeparador\OrderController@OrderDetails',
    ])->middleware('log.route');
    Route::post('/separator/get-orders', [
        'uses' => 'ApiSeparador\OrderController@getOrders',
    ])->middleware('log.route');
    Route::post('/separator/get-order-items', [
        'uses' => 'ApiSeparador\OrderController@getOrderItems',
    ])->middleware('log.route');

    Route::post('/separator/accept-separation', [
        'uses' => 'ApiSeparador\OrderController@acceptSeparation',
    ])->middleware('log.route');

    Route::post('/separator/mark-as-separated', [
        'uses' => 'ApiSeparador\OrderController@markAsSeparated',
    ])->middleware('log.route');

    Route::post('/separator/mark-item-as-separated', [
        'uses' => 'ApiSeparador\OrderController@markItemAsSeparated',
    ])->middleware('log.route');

   

    Route::post('/separator/mark-item-as-unavailable', [
        'uses' => 'ApiSeparador\OrderController@markItemAsUnavailable',
    ])->middleware('log.route');

    Route::post('/separator/substitute-item', [
        'uses' => 'ApiSeparador\OrderController@substituteItem',
    ])->middleware('log.route');

    Route::post('/separator/update-item', [
        'uses' => 'ApiSeparador\OrderController@updateItem',
    ])->middleware('log.route');

    Route::post('/separator/get-item-by-ean', [
        'uses' => 'ApiSeparador\OrderController@getItemByEan',
    ])->middleware('log.route');

    Route::post('/test-iugu', [
        'uses' => 'GeralController@TestIugu',
    ])->middleware('log.route');
   
    Route::post('/affiliate-informations', [
        'uses' => 'Api\AffiliateController@general',
    ])->middleware('log.route');

    Route::post('/insert-referral-code', [
        'uses' => 'Api\AffiliateController@insertReferralCode',
    ])->middleware('log.route');

    Route::post('/apply-coupon', [
        'uses' => 'Api\CouponController@applyCoupon',
    ])->middleware('log.route');

    Route::post('/order-details', [
        'uses' => 'Api\OrderController@OrderDetails',
    ])->middleware('log.route');


    Route::group(['middleware' => ['isactiveuser']], function () {
        Route::post('/place-order', [
            'uses' => 'Api\OrderController@placeOrder',
        ])->middleware('log.route');
    });

    Route::group(['middleware' => ['isactiveuser']], function () {
        Route::post('/place-payment', [
            'uses' => 'Api\OrderController@placePayment',
        ])->middleware('log.route');
    });

 
    Route::post('/user-claim', [
            'uses' => 'Api\UserController@userClaim',
    ])->middleware('log.route');



    Route::post('/orders', [
        'uses' => 'OrderController@Orders',
    ])->middleware('log.route');
  

    Route::post('/save-notification-token', [
        'uses' => 'NotificationController@saveToken',
    ])->middleware('log.route');

    Route::post('/get-payment-gateways', [
        'uses' => 'PaymentController@getPaymentGateways',
    ])->middleware('log.route');

    Route::post('/get-addresses', [
        'uses' => 'AddressController@getAddresses',
    ])->middleware('log.route');
    Route::post('/save-address', [
        'uses' => 'AddressController@saveAddress',
    ])->middleware('log.route');
    Route::post('/delete-address', [
        'uses' => 'AddressController@deleteAddress',
    ])->middleware('log.route');
    Route::post('/update-user-info', [
        'uses' => 'UserController@updateUserInfo',
    ])->middleware('log.route');
    Route::post('/check-running-order', [
        'uses' => 'UserController@checkRunningOrder',
    ])->middleware('log.route');

    

    Route::post('/accept-stripe-payment', [
        'uses' => 'PaymentController@acceptStripePayment',
    ])->middleware('log.route');

    Route::post('/set-default-address', [
        'uses' => 'AddressController@setDefaultAddress',
    ])->middleware('log.route');
    Route::post('/get-orders', [
        'uses' => 'OrderController@getOrders',
    ])->middleware('log.route');

    Route::post('/get-order-items', [
        'uses' => 'OrderController@getOrderItems',
    ])->middleware('log.route');

    Route::post('/cancel-order', [
        'uses' => 'Api\OrderController@cancelOrder',
    ])->middleware('log.route');

    Route::post('/save-new-ratting', [
        'uses' => 'RatingController@saveNewRating',
    ])->middleware('log.route');

    Route::post('/save-restaurant-favorite', [
        'uses' => 'UserController@saveRestaurantAsFavorite',
    ])->middleware('log.route');

    Route::post('/remove-restaurant-favorite', [
        'uses' => 'UserController@removeRestaurantAsFavorite',
    ])->middleware('log.route');

    Route::post('/is-restaurant-favorite', [
        'uses' => 'UserController@isRestaurantFavorite',
    ])->middleware('log.route');

    Route::post('/toggle-restaurant-favorite', [
        'uses' => 'UserController@toggleRestaurantAsFavorite',
    ])->middleware('log.route');

    Route::post('/list-favorite-restaurants', [
        'uses' => 'UserController@ListFavoriteRestaurants',
    ])->middleware('log.route');

    Route::post('/send-order-issue', [
        'uses' => 'OrderController@sendOrderIssue',
    ])->middleware('log.route');

    Route::post('/create-iugu-payment-method', [
        'uses' => 'PaymentController@IuguCriarFormadePagamento',
    ])->middleware('log.route');

    Route::post('/save-user-credit-card', [
        'uses' => 'PaymentController@saveUserCreditCardToken',
    ])->middleware('log.route');

    Route::post('/get-user-credit-cards', [
        'uses' => 'PaymentController@getUserCreditCards',
    ])->middleware('log.route');

    Route::post('/get-iugu-payment-methods', [
        'uses' => 'PaymentController@getIuguPaymentMethod',
    ])->middleware('log.route');
    Route::post('/iugu-criar-cliente-subconta', [
        'uses' => 'PaymentController@IuguCriarClienteSubconta',
    ])->middleware('log.route');

   

    Route::post('/get-ratable-order', [
        'uses' => 'RatingController@getRatableOrder',
    ])->middleware('log.route');

    Route::post('/get-wallet-transactions', [
        'uses' => 'UserController@getWalletTransactions',
    ])->middleware('log.route');

    Route::post('/get-user-notifications', [
        'uses' => 'NotificationController@getUserNotifications',
    ])->middleware('log.route');
    Route::post('/mark-all-notifications-read', [
        'uses' => 'NotificationController@markAllNotificationsRead',
    ])->middleware('log.route');
    Route::post('/mark-one-notification-read', [
        'uses' => 'NotificationController@markOneNotificationRead',
    ])->middleware('log.route');

    Route::post('/delivery/update-user-info', [
        'uses' => 'DeliveryController@updateDeliveryUserInfo',
    ])->middleware('log.route');

    Route::post('/delivery/get-delivery-orders', [
        'uses' => 'DeliveryController@getDeliveryOrders',
    ])->middleware('log.route');

    Route::post('/delivery/get-single-delivery-order', [
        'uses' => 'DeliveryController@getSingleDeliveryOrder',
    ])->middleware('log.route');

    Route::post('/delivery/set-delivery-guy-gps-location', [
        'uses' => 'DeliveryController@setDeliveryGuyGpsLocation',
    ])->middleware('log.route');

    Route::post('/delivery/get-delivery-guy-gps-location', [
        'uses' => 'DeliveryController@getDeliveryGuyGpsLocation',
    ])->middleware('log.route');

    Route::post('/delivery/accept-to-deliver', [
        'uses' => 'DeliveryController@acceptToDeliver',
    ])->middleware('log.route');

    Route::post('/delivery/pickedup-order', [
        'uses' => 'DeliveryController@pickedupOrder',
    ])->middleware('log.route');

    Route::post('/delivery/deliver-order', [
        'uses' => 'DeliveryController@deliverOrder',
    ])->middleware('log.route');

    Route::post('/conversation/chat', [
        'uses' => 'ChatController@deliveryCustomerChat',
    ])->middleware('log.route');

    Route::post('/change-avatar', [
        'uses' => 'UserController@changeAvatar',
    ])->middleware('log.route');

    Route::post('/check-ban', [
        'uses' => 'UserController@checkBan',
    ])->middleware('log.route');
});
/* END Protected Routes */

Route::post('/payment/process-razor-pay', [
    'uses' => 'PaymentController@processRazorpay',
])->middleware('log.route');

Route::get('/payment/process-mercado-pago/{id}', [
    'uses' => 'PaymentController@processMercadoPago',
])->middleware('log.route');
Route::get('/payment/return-mercado-pago', [
    'uses' => 'PaymentController@returnMercadoPago',
])->middleware('log.route');

Route::post('/payment/process-paymongo', [
    'uses' => 'PaymentController@processPaymongo',
])->middleware('log.route');
Route::get('/payment/handle-process-paymongo/{id}', [
    'uses' => 'PaymentController@handlePayMongoRedirect',
])->middleware('log.route');

/* Auth Routes */
Route::post('/login', [
    'uses' => 'UserController@login',
])->middleware('log.route');

Route::post('/register', [
    'uses' => 'UserController@register',
])->middleware('log.route');



Route::post('/delivery/login', [
    'uses' => 'DeliveryController@login',
])->middleware('log.route');
/* END Auth Routes */
