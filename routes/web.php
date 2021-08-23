<?php
Route::impersonate();

/* Setting the locale route */
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});



Route::get('me', 'UserController@me')->middleware('log.route');
/* Installation Routes */
Route::get('install/start', 'InstallController@start');
Route::get('install/pre-installation', 'InstallController@preInstallation');
Route::get('install/configuration', 'InstallController@getConfiguration');
Route::post('install/configuration', 'InstallController@postConfiguration');
Route::get('install/complete', 'InstallController@complete');
/* END Installation Routes */

/* Update Routes */
Route::get('install/update', 'UpdateController@updatePage');
Route::post('install/update', 'UpdateController@update');
/* END Update Routes */

Route::get('/', 'PageController@indexPage')->name('get.index');

Route::get('/schedule/run/{password}', 'SchedulerController@run');
Route::get('/files-backup/run/{password}', 'BackupController@filesBackuprun');
Route::get('/database-backup/run/{password}', 'BackupController@dbBackuprun');

/* Auth Routes */
Route::get('/auth/login', 'PageController@loginPage')->name('get.login');
//Route::get('/auth/password/reset', 'PasswordResetController@getReset')->name('get.resetPassword');
Route::post('/auth/login', 'Auth\LoginController@login')->name('post.login');
Route::get('/auth/register', 'PageController@registerPage')->name('get.register');

Route::get('/auth/logout', 'Auth\LoginController@logout')->name('getlogout');

Route::post('auth/register', 'RegisterController@registerRestaurantDelivery')->name('registerRestaurantDelivery');


/**
 * Password Reset Route(S)
 */
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/**
 * Email Verification Route(s)
 */
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');



Route::get('/orders/check-message/{id}/{phone}', 'RestaurantOwnerController@check_message')->name('panel.checkMessage');

Route::get('home/index', 'Panel\HomeController@index');
Route::get('home/printESCPOS', 'Panel\HomeController@printESCPOS')->name('get.print');
Route::get('PrintESCPOSController', 'Panel\PrintESCPOSController@printCommands')->name('get.printCommands');
Route::any('WebClientPrintController', 'Panel\WebClientPrintController@processRequest')->name('get.printprocessRequest');

/* END Auth Routes */

/* Restaurant Order Routes */
Route::group(['prefix' => 'store-owner', 'middleware' => 'storeowner'], function () {



    Route::get('/orders', 'RestaurantOwnerController@orders')->name('restaurant.orders');
    Route::get('/orders/deleted', 'RestaurantOwnerController@ordersDeleted')->name('panel.ordersDeleted');
    Route::post('/orders/check-contact', 'RestaurantOwnerController@check_contact')->name('panel.checkContact');
   
  
    Route::get('/orders/edit/{id}', 'RestaurantOwnerController@getEditOrder')->name('panel.get.getEditOrder');
    Route::post('/orders/edit/save', 'RestaurantOwnerController@updateOrder')->name('panel.updateOrder');
    Route::post('/orders/new/save', 'RestaurantOwnerController@saveNewOrder')->name('panel.saveNewOrder');
    Route::get('/orders/delete/{id}', 'RestaurantOwnerController@deleteOrder')->name('panel.deleteOrder');
    Route::get('/orders/restore/{id}', 'RestaurantOwnerController@restoreOrder')->name('panel.restoreOrder');


    Route::group(['prefix' => 'dashboards'], function () {
        Route::get('/social-media', [DashboardController::class, 'index'])->name('dashboards.index');
        Route::get('/business', [DashboardController::class, 'business'])->name('dashboards.business');
        Route::get('/performance', [DashboardController::class, 'performance'])->name('dashboards.performance');
        Route::get('/ecommerce', [DashboardController::class, 'ecommerce'])->name('dashboards.ecommerce');
        Route::get('/crm', [DashboardController::class, 'crm'])->name('dashboards.crm');
        Route::get('/sales', [DashboardController::class, 'sales'])->name('dashboards.sales');
    });


    
//Route::get('print', 'Panel\HomeController@index');
//Route::get('home', 'Panel\HomeController@index');

    Route::get('account/profile', 'Panel\AccountController@getEditAccount')->name('panel.accountProfile');
    Route::get('account/plan', 'Panel\AccountController@getEditAccount')->name('panel.accountPlan');
    Route::post('account/profile/save', 'Panel\AccountController@updateProfile')->name('account.saveProfile');



    Route::get('settings/home', 'Panel\SettingController@getEditStart')->name('panel.home');
    Route::get('settings/profile', 'Panel\SettingController@getEditSettings')->name('panel.settingsProfile');
    Route::get('settings/address', 'Panel\SettingController@getEditSettings')->name('panel.settingsAddress');
    Route::get('settings/company-data', 'Panel\SettingController@getEditSettings')->name('panel.settingsCompanyData');
    Route::get('settings/sales-settings', 'Panel\SettingController@getEditSettings')->name('panel.salesSettings');
    Route::get('settings/delivery-time', 'Panel\SettingController@getEditSettings')->name('panel.DeliveryTime');
    Route::get('settings/selfpickup-time', 'Panel\SettingController@getEditSettings')->name('panel.SelfpickupTime');
    Route::get('settings/payment-settings', 'Panel\SettingController@getEditSettings')->name('panel.PaymentSettings');
    Route::get('settings/paymentdelivery-settings', 'Panel\SettingController@getEditSettings')->name('panel.PaymentDeliverySettings');
    Route::get('settings/paymentselfpickup-settings', 'Panel\SettingController@getEditSettings')->name('panel.PaymentSelfpickupSettings');
    Route::get('settings/delivery-calendar', 'Panel\SettingController@getEditSettings')->name('panel.DeliveryCalendar');
    Route::get('settings/selfpickup-calendar', 'Panel\SettingController@getEditSettings')->name('panel.SelfpickupCalendar');
    Route::get('settings/preferences', 'Panel\SettingController@getEditSettings')->name('panel.preferences');
    Route::get('settings/printer', 'Panel\SettingController@getEditSettings')->name('panel.printer');
    Route::get('settings/publish', 'Panel\SettingController@getEditSettings')->name('panel.publishStore');
    Route::get('settings/user-tester', 'Panel\SettingController@getEditSettings')->name('panel.UserTester');
  
    Route::get('settings/terms', 'Panel\SettingController@getEditSettings')->name('panel.terms');
    Route::get('settings/endwizard', 'Panel\SettingController@getEditSettings')->name('panel.endwizard');
   

    Route::post('settings/profile/save', 'Panel\SettingController@updateProfile')->name('settings.saveProfile');
    Route::post('settings/address/save', 'Panel\SettingController@updateAddress')->name('settings.saveAddress');
    Route::post('settings/company-data/save', 'Panel\SettingController@updateCompanyData')->name('settings.saveCompanyData');
    Route::post('settings/sales-settings/save', 'Panel\SettingController@updateSalesSettings')->name('settings.saveSalesSettings');
    Route::post('settings/delivery-time/save', 'Panel\SettingController@updateDeliveryTime')->name('settings.saveDeliveryTime');
    Route::post('settings/selfpickup-time/save', 'Panel\SettingController@updateSelfpickupTime')->name('settings.saveSelfpickupTime');
    Route::post('settings/payment-settings/save', 'Panel\SettingController@updatePaymentSettings')->name('settings.savePaymentSettings');
    Route::post('settings/paymentdelivery-settings/save', 'Panel\SettingController@updatePaymentDeliverySettings')->name('settings.savePaymentDeliverySettings');
    Route::post('settings/paymentselfpickup-settings/save', 'Panel\SettingController@updatePaymentSelfpickupSettings')->name('settings.savePaymentSelfpickupSettings');
    Route::post('settings/delivery-calendar/save', 'Panel\SettingController@updateDeliveryCalendar')->name('settings.saveDeliveryCalendar');
    Route::post('settings/selfpickup-calendar/save', 'Panel\SettingController@updateSelfpickupCalendar')->name('settings.saveSelfpickupCalendar');
    Route::post('settings/preferences/save', 'Panel\SettingController@updatePreferences')->name('settings.savePreferences');
    Route::post('settings/printer/save', 'Panel\SettingController@updateThermalPrinter')->name('settings.savePrinter');
    Route::post('settings/user-tester/save', 'Panel\SettingController@updateUserTester')->name('settings.saveUserTester');
    Route::post('settings/terms/save', 'Panel\SettingController@updateTerms')->name('settings.saveTerms');
    Route::post('settings/publishstore/save', 'Panel\SettingController@publishStore')->name('settings.publishStore');


    Route::get('setup/home', 'Wizard\WizardController@getEditWizardHome')->name('wizard.wizard_home');
    Route::get('setup/step1', 'Wizard\WizardController@getEditWizard1')->name('wizard.wizard_1');
    Route::post('setup/step1/save', 'Wizard\WizardController@updateWizard1')->name('wizard.savewizard_1');
    Route::get('setup/step2', 'Wizard\WizardController@getEditWizard2')->name('wizard.wizard_2');
    Route::post('setup/step2/save', 'Wizard\WizardController@updateWizard2')->name('wizard.savewizard_2');
    Route::get('setup/step3', 'Wizard\WizardController@getEditWizard3')->name('wizard.wizard_3');
    Route::post('setup/step3/save', 'Wizard\WizardController@updateWizard3')->name('wizard.savewizard_3');
    Route::get('setup/step4', 'Wizard\WizardController@getEditWizard4')->name('wizard.wizard_4');
    Route::post('setup/step4/save', 'Wizard\WizardController@updateWizard4')->name('wizard.savewizard_4');
    Route::get('setup/step4_1', 'Wizard\WizardController@getEditWizard4_1')->name('wizard.wizard_4_1');
    Route::post('setup/step4_1/save', 'Wizard\WizardController@updateWizard4_1')->name('wizard.savewizard_4_1');
    Route::get('setup/step4_2', 'Wizard\WizardController@getEditWizard4_2')->name('wizard.wizard_4_2');
    Route::post('setup/step4_2/save', 'Wizard\WizardController@updateWizard4_2')->name('wizard.savewizard_4_2');
    Route::get('setup/step4_3', 'Wizard\WizardController@getEditWizard4_3')->name('wizard.wizard_4_3');
    Route::post('setup/step4_3/save', 'Wizard\WizardController@updateWizard4_3')->name('wizard.savewizard_4_3');


    Route::get('setup/step5', 'Wizard\WizardController@getEditWizard5')->name('wizard.wizard_5');
    Route::post('setup/step5/save', 'Wizard\WizardController@updateWizard5')->name('wizard.savewizard_5');
    Route::get('setup/step5_1', 'Wizard\WizardController@getEditWizard5_1')->name('wizard.wizard_5_1');
    Route::post('setup/step5_1/save', 'Wizard\WizardController@updateWizard5_1')->name('wizard.savewizard_5_1');
    Route::get('setup/step6', 'Wizard\WizardController@getEditWizard6')->name('wizard.wizard_6');
    Route::post('setup/step6/save', 'Wizard\WizardController@updateWizard6')->name('wizard.savewizard_6');
    Route::get('setup/step7', 'Wizard\WizardController@getEditWizard7')->name('wizard.wizard_7');
    Route::post('setup/step7/save', 'Wizard\WizardController@updateWizard7')->name('wizard.savewizard_7');
    Route::get('setup/step8', 'Wizard\WizardController@getEditWizard8')->name('wizard.wizard_8');
    Route::post('setup/step8/save', 'Wizard\WizardController@updateWizard8')->name('wizard.savewizard_8');

    Route::get('setup/end', 'Wizard\WizardController@getEditWizardEnd')->name('wizard.wizard_end');

    Route::get('wizard/panel', 'Wizard\WizardController@getEditWizardPanel')->name('wizard.wizard_panel');
   
    Route::get('cashback', 'Panel\CashbackController@getEditCashback')->name('panel.cashback');
    Route::post('cashback/save', 'Panel\CashbackController@updateCashback')->name('panel.updateCashback');

   
    Route::get('/orders/searchOrders', 'RestaurantOwnerController@postSearchOrders')->name('restaurant.post.searchOrders');
    Route::get('/order/{order_id}', 'Panel\OrderController@viewOrder')->name('panel.viewOrder');
    Route::post('/order/select-separator', 'Panel\OrderController@selectSeparator')->name('panel.selectSeparator');

    Route::get('/balance', 'Panel\BalanceController@balance')->name('panel.balance.deposits');
    Route::get('/balance/success', 'Panel\BalanceController@balance')->name('panel.balance.depositSuccess');
    Route::get('/balance/pendent', 'Panel\BalanceController@balance')->name('panel.balance.depositPendent');
   

    Route::get('/orders', 'RestaurantOwnerController@orders')->name('restaurant.orders');
    Route::post('/orders/get-new-orders', 'RestaurantOwnerController@getNewOrders')->name('restaurant.getNewOrders');
    Route::post('/orders/new-orders-notification', 'RestaurantOwnerController@newOrdersNotification')->name('restaurant.newOrdersNotification');
    Route::post('/orders/new-orders-ids-notification', 'RestaurantOwnerController@newOrdersIdsNotification')->name('restaurant.newOrdersIdsNotification');


    Route::get('/orders/accept-order/{id}', 'Panel\OrderController@acceptOrder')->name('panel.acceptOrder');
    Route::get('/orders/mark-order-ready/{id}', 'Panel\OrderController@markOrderReady')->name('panel.markOrderReady');
    Route::get('/orders/mark-selfpickup-order-completed/{id}', 'Panel\OrderController@markSelfPickupOrderAsCompleted')->name('panel.markSelfPickupOrderAsCompleted');
    Route::get('/orders/mark-order-ready/{id}', 'Panel\OrderController@markOrderReady')->name('panel.markOrderReady');
    Route::get('/orders/mark-order-as-onway/{id}', 'Panel\OrderController@markOrderAsOnway')->name('panel.markOrderAsOnway');
    Route::get('/orders/mark-order-as-delivered/{id}', 'Panel\OrderController@markOrderAsDelivered')->name('panel.markOrderAsDelivered');
    Route::post('/orders/cancel-order', 'Panel\OrderController@cancelOrder')->name('panel.cancelOrder');

    Route::get('/stores', 'RestaurantOwnerController@restaurants')->name('restaurant.restaurants');
    Route::get('/store/edit', 'RestaurantOwnerController@getEditRestaurant')->name('restaurant.get.editRestaurant');
    Route::post('/store/new/save', 'RestaurantOwnerController@saveNewRestaurant')->name('restaurant.saveNewRestaurant');
    Route::get('/store/disable/{id}', 'RestaurantOwnerController@disableRestaurant')->name('restaurant.disableRestaurant');
    Route::get('/store/delete/{id}', 'RestaurantOwnerController@deleteRestaurant')->name('restaurant.deleteRestaurant');
    Route::post('/store/edit/save', 'RestaurantOwnerController@updateRestaurant')->name('restaurant.updateRestaurant');
    Route::post('/store/new/save', 'RestaurantOwnerController@saveNewRestaurant')->name('restaurant.saveNewRestaurant');
    Route::post('/storelogo/edit/save', 'RestaurantOwnerController@uploadLogoRestaurant')->name('restaurant.uploadLogoRestaurant');

    Route::post('/store/schedule/save', 'RestaurantOwnerController@updateRestaurantScheduleData')->name('restaurant.updateRestaurantScheduleData');

    
    Route::get('/itemcategories', 'Panel\ItemCategoryController@itemcategories')->name('panel.itemcategories');
    Route::get('/itemcategories/deleted', 'Panel\ItemCategoryController@itemcategories_deleted')->name('panel.itemcategoriesDeleted');
   
    Route::post('/itemcategories/new/save', 'Panel\ItemCategoryController@createItemCategory')->name('panel.createItemCategory');
      Route::post('/itemcategories/edit/save', 'Panel\ItemCategoryController@updateItemCategory')->name('panel.updateItemCategory');
    Route::get('/itemcategories/delete/{id}', 'Panel\ItemCategoryController@deleteItemCategory')->name('panel.deleteItemCategory');
    Route::get('/itemcategories/restore/{id}', 'Panel\ItemCategoryController@restoreItemCategory')->name('panel.restoreItemCategory');


/*     Route::get('/addoncategories', 'RestaurantOwnerController@addonCategories')->name('restaurant.addonCategories');
    Route::get('/addoncategories/searchAddonCategories', 'RestaurantOwnerController@searchAddonCategories')->name('restaurant.post.searchAddonCategories');
    Route::get('/addoncategory/edit/{id}', 'RestaurantOwnerController@getEditAddonCategory')->name('restaurant.editAddonCategory');
    Route::post('/addoncategory/edit/save', 'RestaurantOwnerController@updateAddonCategory')->name('restaurant.updateAddonCategory');
    Route::get('/addoncategory/new', 'RestaurantOwnerController@newAddonCategory')->name('restaurant.newAddonCategory');
    Route::post('/addoncategory/new/save', 'RestaurantOwnerController@saveNewAddonCategory')->name('restaurant.saveNewAddonCategory'); */

  /*   Route::get('/addons', 'RestaurantOwnerController@addons')->name('restaurant.addons');
    Route::get('/addons/searchAddons', 'RestaurantOwnerController@searchAddons')->name('restaurant.post.searchAddons');
    Route::get('/addon/edit/{id}', 'RestaurantOwnerController@getEditAddon')->name('restaurant.editAddon');
    Route::post('/addon/edit/save', 'RestaurantOwnerController@updateAddon')->name('restaurant.updateAddon');
    Route::post('/addon/new/save', 'RestaurantOwnerController@saveNewAddon')->name('restaurant.saveNewAddon');
    Route::get('/addon/disable/{id}', 'RestaurantOwnerController@disableAddon')->name('restaurant.disableAddon');
    Route::get('/addon/delete/{id}', 'RestaurantOwnerController@deleteAddon')->name('restaurant.deleteAddon'); */

    Route::get('/addoncategories', 'Panel\AddonController@addonsCategories')->name('panel.addons');
    Route::get('/addon-categories/deleted', 'Panel\AddonController@addonCategories_deleted')->name('panel.addonCategoriesDeleted');
    Route::get('/addoncategories/inactive', 'Panel\AddonController@inactive_addons')->name('panel.inactiveAddons');
    Route::get('/addoncategories/active', 'Panel\AddonController@active_addons')->name('panel.activeAddons');
    Route::post('/addoncategories/new/save', 'Panel\AddonController@saveNewAddonCategory')->name('panel.saveNewAddonCategory');
    Route::get('/addoncategories/edit/{id}', 'Panel\AddonController@getEditAddonCategory')->name('panel.getEditAddonCategory');
    Route::post('/addoncategories/edit/save', 'Panel\AddonController@updateAddonCategory')->name('panel.updateAddonCategory');
    Route::get('/addoncategories/delete/{id}', 'Panel\AddonController@deleteAddonCategory')->name('panel.deleteAddonCategory');
    Route::get('/addoncategories/restore/{id}', 'Panel\AddonController@restoreAddonCategory')->name('panel.restoreAddonCategory');
    Route::post('/addons/new/save', 'Panel\AddonController@saveNewAddon')->name('panel.createAddon');
    Route::post('/addons/edit/save', 'Panel\AddonController@updateAddon')->name('panel.updateAddon');
    Route::get('/addons/delete/{id}', 'Panel\AddonController@deleteAddon')->name('panel.deleteAddon');


    Route::get('/coupons', 'Panel\CouponController@coupons')->name('panel.coupons');
    Route::get('/coupons/deleted', 'Panel\CouponController@coupons_deleted')->name('panel.couponsDeleted');
    Route::get('/coupons/expired', 'Panel\CouponController@coupons_expired')->name('panel.couponsExpired');
    Route::get('/coupons/active', 'Panel\CouponController@coupons_nonexpired')->name('panel.couponsNonExpired');
    Route::post('/coupon/new/save', 'Panel\CouponController@saveNewCoupon')->name('panel.post.saveNewCoupon');
    Route::get('/coupon/edit/{id}', 'Panel\CouponController@getEditCoupon')->name('panel.get.getEditCoupon');
    Route::post('/coupon/edit/save', 'Panel\CouponController@updateCoupon')->name('panel.updateCoupon');
    Route::get('/coupon/delete/{id}', 'Panel\CouponController@deleteCoupon')->name('panel.deleteCoupon');
    Route::get('/coupon/restore/{id}', 'Panel\CouponController@restoreCoupon')->name('panel.restoreCoupon');

    Route::get('/flyers', 'Panel\FlyerController@flyers')->name('panel.flyers');
    Route::get('/flyers/deleted', 'Panel\FlyerController@flyers_deleted')->name('panel.flyersDeleted');
    Route::get('/flyers/expired', 'Panel\FlyerController@flyers_expired')->name('panel.flyersExpired');
    Route::get('/flyers/active', 'Panel\FlyerController@flyers_nonexpired')->name('panel.flyersNonExpired');
    Route::post('/flyers/new/save', 'Panel\FlyerController@saveNewFlyer')->name('panel.saveNewFlyer');
    Route::get('/flyers/edit/{id}', 'Panel\FlyerController@getEditFlyer')->name('panel.get.editFlyer');
    Route::post('/flyers/edit/save', 'Panel\FlyerController@updateFlyer')->name('panel.updateFlyer');
    Route::get('/flyers/delete/{id}', 'Panel\FlyerController@deleteFlyer')->name('panel.deleteFlyer');
    Route::get('/flyers/restore/{id}', 'Panel\FlyerController@restoreFlyer')->name('panel.restoreFlyer');

    Route::get('/separators', 'Panel\SeparatorController@separators')->name('panel.separators');
    Route::get('/separators/deleted', 'Panel\SeparatorController@deletedSeparators')->name('panel.deletedSeparators');
    Route::get('/separators/free', 'Panel\SeparatorController@freeSeparators')->name('panel.freeSeparators');
    Route::get('/separators/working', 'Panel\SeparatorController@workingSeparators')->name('panel.workingSeparators');
    Route::post('/separators/new/save', 'Panel\SeparatorController@saveNewSeparator')->name('panel.saveNewSeparator');
    Route::get('/separators/edit/{id}', 'Panel\SeparatorController@getEditSeparator')->name('panel.editSeparator');
    Route::post('/separators/edit/save', 'Panel\SeparatorController@updateSeparator')->name('panel.updateSeparator');
    Route::get('/separators/delete/{id}', 'Panel\SeparatorController@deleteSeparator')->name('panel.deleteSeparator');
    Route::get('/separators/restore/{id}', 'Panel\SeparatorController@restoreSeparator')->name('panel.restoreSeparator');

    Route::get('/customers', 'Panel\CustomerController@customers')->name('panel.customers');

    Route::get('/sorteios', 'Panel\SorteioController@sorteios')->name('panel.sorteios');
    Route::post('/sorteio/new/save', 'Panel\SorteioController@saveNewSorteio')->name('panel.post.saveNewSorteio');
    Route::get('/sorteio/edit/{id}', 'Panel\SorteioController@getEditSorteio')->name('panel.get.getEditSorteio');
    Route::post('/sorteio/edit/save', 'Panel\SorteioController@updateSorteio')->name('panel.updateSorteio');
    Route::get('/sorteio/delete/{id}', 'Panel\SorteioController@deleteSorteio')->name('panel.deleteSorteio');


    Route::get('/items', 'Panel\ItemController@items')->name('panel.items');
    Route::get('/items/deleted', 'Panel\ItemController@itensDeleted')->name('panel.itensDeleted');
    Route::get('/items/active', 'Panel\ItemController@itemsActive')->name('panel.itemsActive');
    Route::get('/items/inactive', 'Panel\ItemController@itemsInActive')->name('panel.itemsInActive');
    Route::get('/items/offer', 'Panel\ItemController@itemsOffer')->name('panel.itemsOffer');
    Route::get('/items/itemsWithoutImage', 'Panel\ItemController@itemsWithoutImage')->name('panel.itemsWithoutImage');
    Route::get('/stores/searchItems', 'Panel\ItemController@searchItems')->name('restaurant.post.searchItems');
    Route::get('/items/edit/{id}', 'Panel\ItemController@getEditItem')->name('panel.get.editItem');
    Route::get('/item/disable/{id}', 'Panel\ItemController@disableItem')->name('panel.disableItem');
    Route::get('/item/delete/{id}', 'Panel\ItemController@deleteItem')->name('panel.deleteItem');
    Route::get('/item/restore/{id}', 'Panel\ItemController@restoreItem')->name('panel.restoreItem');
    Route::post('/item/edit/save', 'Panel\ItemController@updateItem')->name('panel.updateItem');
    Route::post('/item/new/save', 'Panel\ItemController@saveNewItem')->name('panel.saveNewItem');
    Route::post('/item/bulk/save', 'BulkUploadController@itemBulkUploadFromRestaurant')->name('restaurant.itemBulkUpload');
    Route::get('/itemsDataTable', 'Datatables\ItemsDatatable@itemsDataTable')->name('restaurant.itemsDataTable');

    Route::get('/items-cardapio', 'Panel\ItemController@itemsCardapio')->name('panel.itemsCardapio');
    Route::post('/item-flavor/new/save', 'Panel\ItemController@saveNewFlavor')->name('panel.saveNewFlavor');
    Route::post('/item-pizzacategory/new/save', 'Panel\ItemController@saveNewPizzaCategory')->name('panel.saveNewPizzaCategory');
    Route::get('/item-cardapio/delete/{id}', 'Panel\ItemController@deletePizzaFlavor')->name('panel.deletePizzaFlavor');
    Route::get('/item-pizzacategory/edit/{id}', 'Panel\ItemController@geteditPizzaCategory')->name('panel.get.editPizzaCategory');
    Route::post('/item-pizzacategory/edit/save', 'Panel\ItemController@updatePizzaCategory')->name('panel.updatePizzaCategory');
    Route::get('/item/delete-pizzacategory/{id}', 'Panel\ItemController@deletePizzaCategory')->name('panel.deletePizzaCategory');
    Route::get('/item/delete-itemcategory/{id}', 'Panel\ItemController@deleteItemCategory')->name('panel.deleteItemCategory');
    
    Route::get('/get-ajax-pizza-sizes/{id}', 'Panel\ItemController@getAjaxPizzaSizesFromCategory')->name('panel.getAjaxPizzaSizesFromCategory');
    Route::get('/get-ajax-pizza-sizes-id/{id}', 'Panel\ItemController@getAjaxPizzaSizesFromId')->name('panel.getAjaxPizzaSizesFromId');
    Route::get('/get-ajax-pizza-prices/{id}', 'Panel\ItemController@getAjaxPizzaPricesFromCategory')->name('panel.getAjaxPizzaPricesFromCategory');
    
    /* Route::get('/flyers', 'RestaurantOwnerController@flyers')->name('restaurant.flyers');
   
    Route::get('/flyers/edit/{id}', 'RestaurantOwnerController@getEditFlyer')->name('restaurant.get.editFlyer');
    Route::get('/flyer/disable/{id}', 'RestaurantOwnerController@disableFlyer')->name('restaurant.disableFlyer');
    Route::post('/flyer/edit/save', 'RestaurantOwnerController@updateFlyer')->name('restaurant.updateFlyer');
    Route::post('/flyernew/save', 'RestaurantOwnerController@saveNewFlyer')->name('restaurant.saveNewFlyer'); */
    

    Route::get('/orders', 'RestaurantOwnerController@orders')->name('restaurant.orders');
    Route::get('/orders/searchOrders', 'RestaurantOwnerController@postSearchOrders')->name('restaurant.post.searchOrders');
    Route::get('/orderr/{order_id}', 'RestaurantOwnerController@viewOrder')->name('restaurant.viewOrder');

    Route::get('/earnings/{restaurant_id?}', 'RestaurantOwnerController@earnings')->name('restaurant.earnings');
    Route::post('/earnings/send-payout-request', 'RestaurantOwnerController@sendPayoutRequest')->name('restaurant.sendPayoutRequest');

    Route::post('/save-store-owner-notification-token', 'NotificationController@saveRestaurantOwnerNotificationToken')->name('saveRestaurantOwnerNotificationToken');

    Route::get('zen-mode/{status}', function ($status) {
        Session::put('zenMode', $status);  
        return redirect()->route('restaurant.dashboard');
    })->name('restaurant.zenMode');

    Route::post('/check-order-status-new-order', 'RestaurantOwnerController@checkOrderStatusNewOrder')->name('restaurant.checkOrderStatusNewOrder');
    Route::post('/check-order-status-selfpickup-order', 'RestaurantOwnerController@checkOrderStatusSelfPickupOrder')->name('restaurant.checkOrderStatusSelfPickupOrder');

    Route::post('/update-store-payout-details', 'RestaurantOwnerController@updateStorePayoutDetails')->name('restaurant.updateStorePayoutDetails');

    Route::get('/dashboard', 'RestaurantOwnerController@dashboard')->name('restaurant.dashboard');  

    Route::get('/ordersDataTableRestaurant', 'Datatables\OrdersDatatable@ordersDataTableRestaurant')->name('restaurant.ordersDataTable');


});
/* END Restaurant Owner Routes */

/* Admin Routes */
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {


    Route::get('/stores', 'Admin\AdminController@restaurants')->name('admin.stores');
    Route::get('/stores/deleted', 'Admin\AdminController@storesDeleted')->name('admin.storesDeleted');
    Route::get('/store/edit/{id}', 'Admin\AdminController@getEditRestaurant')->name('admin.getEditStore');
    Route::get('/store/disable/{id}', 'Admin\AdminController@disableRestaurant')->name('admin.disableRestaurant');
    Route::get('/store/delete/{id}', 'Admin\AdminController@deleteRestaurant')->name('admin.deleteStore');
    Route::post('/store/edit/save', 'Admin\AdminController@updateRestaurant')->name('admin.updateRestaurant');
    Route::post('/store/new/save', 'Admin\AdminController@saveNewRestaurant')->name('admin.saveNewRestaurant');


    Route::get('/sellers', 'Admin\AdminController@sellers')->name('admin.sellers');
    Route::get('/sellers/deleted', 'Admin\AdminController@sellersDeleted')->name('admin.sellersDeleted');
    Route::get('/sellers/edit/{id}', 'Admin\AdminController@getEditSeller')->name('admin.get.editSeller');
    Route::get('/sellers/disable/{id}', 'Admin\AdminController@disableSeller')->name('admin.disableSeller');
    Route::get('/sellers/delete/{id}', 'Admin\AdminController@deleteSeller')->name('admin.deleteSeller');
    Route::post('/sellers/edit/save', 'Admin\AdminController@updateSeller')->name('admin.updateSeller');
    Route::post('/sellers/new/save', 'Admin\AdminController@saveNewSeller')->name('admin.saveNewSeller');
    


    Route::get('/processPayment', 'AdminController@processPayment')->name('admin.processPayment');

    Route::get('/manage-delivery-guys', 'AdminController@manageDeliveryGuys')->name('admin.manageDeliveryGuys');
    Route::get('/manage-delivery-guys-stores/{id}', 'AdminController@getManageDeliveryGuysRestaurants')->name('admin.get.manageDeliveryGuysRestaurants');
    Route::post('/update-delivery-guys-stores', 'AdminController@updateDeliveryGuysRestaurants')->name('admin.updateDeliveryGuysRestaurants');

    Route::get('/manage-store-owners', 'AdminController@manageRestaurantOwners')->name('admin.manageRestaurantOwners');
    Route::get('/manage-store-owners-stores/{id}', 'AdminController@getManageRestaurantOwnersRestaurants')->name('admin.get.getManageRestaurantOwnersRestaurants');
    Route::post('/update-store-owners-stores', 'AdminController@updateManageRestaurantOwnersRestaurants')->name('admin.updateManageRestaurantOwnersRestaurants');

    Route::get('/users', 'AdminController@users')->name('admin.users');
    Route::get('/usersDatatable', 'Datatables\UsersDatatable@usersDatatable')->name('admin.usersDatatable');

    Route::post('/saveNewUser', 'AdminController@saveNewUser')->name('admin.saveNewUser');

    Route::get('/users/searchUsers', 'AdminController@postSearchUsers')->name('admin.post.searchUsers');

    Route::get('/user/edit/{id}', 'AdminController@getEditUser')->name('admin.get.editUser');
    Route::post('/user/edit/save', 'AdminController@updateUser')->name('admin.updateUser');

    Route::get('/user/ban/{id}', 'AdminController@banUser')->name('admin.banUser');

    Route::post('/user/add-money-to-wallet', 'AdminController@addMoneyToWallet')->name('admin.addMoneyToWallet');
    Route::post('/user/substract-money-from-wallet', 'AdminController@substractMoneyFromWallet')->name('admin.substractMoneyFromWallet');

    Route::get('/wallet/transactions', 'AdminController@walletTransactions')->name('admin.walletTransactions');
    Route::get('/wallet/searchWalletTransactions', 'AdminController@searchWalletTransactions')->name('admin.searchWalletTransactions');

    Route::get('/settings', 'SettingController@settings')->name('admin.settings');
    Route::post('/settings', 'SettingController@saveSettings')->name('admin.saveSettings');
    Route::post('/settings/send-test-mail', 'SettingController@sendTestmail')->name('admin.sendTestmail');
    Route::post('/settings/payment-gateways-toggle', 'PaymentController@togglePaymentGateways')->name('admin.togglePaymentGateways');

    Route::get('/orders', 'AdminController@orders')->name('admin.orders');
    Route::get('/ordersDataTable', 'Datatables\OrdersDatatable@ordersDataTable')->name('admin.ordersDataTable');
    Route::get('/orders/searchOrders', 'AdminController@postSearchOrders')->name('admin.post.searchOrders');
    Route::get('/order/{order_id}', 'AdminController@viewOrder')->name('admin.viewOrder');
    Route::post('/order/cancel-order', 'AdminController@cancelOrderFromAdmin')->name('admin.cancelOrderFromAdmin');
    Route::post('/order/accept-order', 'AdminController@acceptOrderFromAdmin')->name('admin.acceptOrderFromAdmin');
    Route::post('/order/assign-delivery', 'AdminController@assignDeliveryFromAdmin')->name('admin.assignDeliveryFromAdmin');
    Route::post('/order/reassign-delivery', 'AdminController@reAssignDeliveryFromAdmin')->name('admin.reAssignDeliveryFromAdmin');

    Route::get('/sliders', 'AdminController@sliders')->name('admin.sliders');
    Route::get('/sliders/disable/{id}', 'AdminController@disableSlider')->name('admin.disableSlider');
    Route::get('/sliders/delete/{id}', 'AdminController@deleteSlider')->name('admin.deleteSlider');
    Route::get('/sliders/{id}', 'AdminController@getEditSlider')->name('admin.get.editSlider');
    Route::post('/slider/create', 'AdminController@createSlider')->name('admin.createSlider');
    Route::post('/slider/save', 'AdminController@saveSlide')->name('admin.saveSlide');
    Route::post('/sliders/edit/save', 'AdminController@updateSlider')->name('admin.updateSlider');

    Route::get('/slider/delete/{id}', 'AdminController@deleteSlide')->name('admin.deleteSlide');
    Route::get('/slider/disable/{id}', 'AdminController@disableSlide')->name('admin.disableSlide');

    Route::get('/slide/edit/{id}', 'AdminController@editSlide')->name('admin.editSlide');
    Route::post('/slide/edit/save', 'AdminController@updateSlide')->name('admin.updateSlide');
    Route::post('/slide/edit/position/save', 'AdminController@updateSlidePosition')->name('admin.updateSlidePosition');

    
    Route::get('/stores/asked-publish', 'Admin\AdminController@askedPublish')->name('admin.askedPublish');
    Route::get('/stores/publish-store/{id}', 'Admin\AdminController@publishStore')->name('admin.publishStore');
    Route::get('/stores/unpublish-store/{id}', 'Admin\AdminController@unpublishStore')->name('admin.unpublishStore');
    Route::get('/stores/sort', 'Admin\AdminController@sortStores')->name('admin.sortStores');
    Route::post('/stores/sort/save', 'Admin\AdminController@updateStorePosition')->name('admin.updateStorePosition');
    Route::post('/stores/plans/save', 'Admin\AdminController@editPlanTaxes')->name('admin.updatePlanTaxes');
    Route::get('/stores/verify/{id}', 'Admin\AdminController@iuguVerify')->name('admin.iuguVerify');
    Route::get('/stores/verifyverify/{id}', 'Admin\AdminController@iuguVerifyVerify')->name('admin.iuguVerifyVerify');

    Route::get('/stores/pending-acceptance/accept/{id}', 'Admin\AdminController@acceptRestaurant')->name('admin.acceptRestaurant');
    Route::get('/stores/searchRestaurants', 'Admin\AdminController@searchRestaurants')->name('admin.post.searchRestaurants');
   
    Route::post('/store/bulk/save', 'Admin\BulkUploadController@restaurantBulkUpload')->name('admin.restaurantBulkUpload');
    Route::get('/store/{restaurant_id}/items', 'Admin\AdminController@getRestaurantItems')->name('admin.getRestaurantItems');

    Route::post('/store/schedule/save', 'AdminController@updateRestaurantScheduleData')->name('admin.updateRestaurantScheduleData');

    Route::post('/store/update-slug', 'AdminController@updateSlug')->name('admin.updateSlug');

    Route::get('/addoncategories', 'AdminController@addonCategories')->name('admin.addonCategories');
    Route::get('/addoncategories/searchAddonCategories', 'AdminController@searchAddonCategories')->name('admin.post.searchAddonCategories');
    Route::get('/addoncategory/edit/{id}', 'AdminController@getEditAddonCategory')->name('admin.editAddonCategory');
    Route::post('/addoncategory/edit/save', 'AdminController@updateAddonCategory')->name('admin.updateAddonCategory');
    Route::get('/addoncategory/new', 'AdminController@newAddonCategory')->name('admin.newAddonCategory');
    Route::post('/addoncategory/new/save', 'AdminController@saveNewAddonCategory')->name('admin.saveNewAddonCategory');
    Route::get('/addoncategory/get-addons/{id}', 'AdminController@addonsOfAddonCategory')->name('admin.addonsOfAddonCategory');

    Route::get('/addons', 'AdminController@addons')->name('admin.addons');
    Route::get('/addons/searchAddons', 'AdminController@searchAddons')->name('admin.post.searchAddons');
    Route::get('/addon/edit/{id}', 'AdminController@getEditAddon')->name('admin.editAddon');
    Route::post('/addon/edit/save', 'AdminController@updateAddon')->name('admin.updateAddon');
    Route::post('/addon/new/save', 'AdminController@saveNewAddon')->name('admin.saveNewAddon');
    Route::get('/addon/disable/{id}', 'AdminController@disableAddon')->name('admin.disableAddon');
    Route::get('/addon/delete/{id}', 'AdminController@deleteAddon')->name('admin.deleteAddon');

    Route::get('/items', 'AdminController@items')->name('admin.items');
    Route::get('/items/searchItems', 'AdminController@searchItems')->name('admin.post.searchItems');
    Route::get('/item/edit/{id}', 'AdminController@getEditItem')->name('admin.get.editItem');
    Route::get('/item/disable/{id}', 'AdminController@disableItem')->name('admin.disableItem');
    Route::post('/item/edit/save', 'AdminController@updateItem')->name('admin.updateItem');
    Route::post('/item/new/save', 'AdminController@saveNewItem')->name('admin.saveNewItem');
    Route::post('/item/bulk/save', 'BulkUploadController@itemBulkUpload')->name('admin.itemBulkUpload');

    Route::get('/itemcategories', 'AdminController@itemcategories')->name('admin.itemcategories');
    Route::get('/itemCategoriesDataTable', 'Datatables\ItemCategoriesDatatable@itemCategoriesDataTable')->name('admin.itemCategoriesDataTable');
    Route::post('/itemcategories/new/save', 'AdminController@createItemCategory')->name('admin.createItemCategory');
    Route::get('/itemcategory/disable/{id}', 'AdminController@disableCategory')->name('admin.disableCategory');
    Route::post('/itemcategory/edit/save', 'AdminController@updateItemCategory')->name('admin.updateItemCategory');

    Route::get('/coupons', 'CouponController@coupons')->name('admin.coupons');
    Route::post('/coupon/new/save', 'CouponController@saveNewCoupon')->name('admin.post.saveNewCoupon');
    Route::get('/coupon/edit/{id}', 'CouponController@getEditCoupon')->name('admin.get.getEditCoupon');
    Route::post('/coupon/edit/save', 'CouponController@updateCoupon')->name('admin.updateCoupon');
    Route::get('/coupon/delete/{id}', 'CouponController@deleteCoupon')->name('admin.deleteCoupon');

    Route::get('/notifications', 'NotificationController@notifications')->name('admin.notifications');
    Route::post('/notifications/upload', 'NotificationController@uploadNotificationImage')->name('admin.uploadNotificationImage');
    Route::post('/notifications/send', 'NotificationController@sendNotifiaction')->name('admin.sendNotifiaction');
    Route::post('/notification-to-users/send', 'NotificationController@sendNotificationToSelectedUsers')->name('admin.sendNotificationToSelectedUsers');

    Route::get('/popular-geo-locations', 'AdminController@popularGeoLocations')->name('admin.popularGeoLocations');
    Route::post('/popular-geo-location/new/save', 'AdminController@saveNewPopularGeoLocation')->name('admin.saveNewPopularGeoLocation');
    Route::get('/popular-geo-location/disable/{id}', 'AdminController@disablePopularGeoLocation')->name('admin.disablePopularGeoLocation');
    Route::get('/popular-geo-location/delete/{id}', 'AdminController@deletePopularGeoLocation')->name('admin.deletePopularGeoLocation');

    Route::get('/pages', 'AdminController@pages')->name('admin.pages');
    Route::post('/page/new/save', 'AdminController@saveNewpage')->name('admin.saveNewPage');
    Route::get('/page/edit/{id}', 'AdminController@getEditPage')->name('admin.getEditPage');
    Route::post('/page/edit/save', 'AdminController@updatePage')->name('admin.updatePage');
    Route::get('/page/delete/{id}', 'AdminController@deletePage')->name('admin.deletePage');

    Route::get('/store-payouts', 'AdminController@restaurantpayouts')->name('admin.restaurantpayouts');
    Route::get('/store-payouts/{id}', 'AdminController@viewRestaurantPayout')->name('admin.viewRestaurantPayout');
    Route::post('/store-payouts/save', 'AdminController@updateRestaurantPayout')->name('admin.updateRestaurantPayout');

    Route::get('/update/check', '\pcinaglia\laraupdater\LaraUpdaterController@check')->name('admin.checkForUpdates');
    Route::get('/update/perform-update', '\pcinaglia\laraupdater\LaraUpdaterController@update')->name('admin.performUpdate');

    Route::get('/translations', 'AdminController@translations')->name('admin.translations');
    Route::get('/translation/new', 'AdminController@newTranslation')->name('admin.newTranslation');
    Route::post('/translation/new/save', 'AdminController@saveNewTranslation')->name('admin.saveNewTranslation');
    Route::get('/translation/edit/{id}', 'AdminController@editTranslation')->name('admin.editTranslation');
    Route::post('/translation/edit/save', 'AdminController@updateTranslation')->name('admin.updateTranslation');
    Route::get('/translation/disable/{id}', 'AdminController@disableTranslation')->name('admin.disableTranslation');
    Route::get('/translation/delete/{id}', 'AdminController@deleteTranslation')->name('admin.deleteTranslation');
    Route::get('/translation/make-default/{id}', 'AdminController@makeDefaultLanguage')->name('admin.makeDefaultLanguage');

    Route::get('/delivery-collections', 'DeliveryCollectionController@deliveryCollections')->name('admin.deliveryCollections');
    Route::post('/delivery-collection/collect/{id}', 'DeliveryCollectionController@collectDeliveryCollection')->name('admin.collectDeliveryCollection');

    Route::get('/delivery-collection-logs', 'DeliveryCollectionController@deliveryCollectionLogs')->name('admin.deliveryCollectionLogs');
    Route::get('/delivery-collection-logs/{id}', 'DeliveryCollectionController@deliveryCollectionLogsForSingleUser')->name('admin.deliveryCollectionLogsForSingleUser');

    Route::get('/store-category-slider', 'RestaurantCategoryController@restaurantCategorySlider')->name('admin.restaurantCategorySlider');
    Route::get('/store-category-slider/delete/{id}', 'RestaurantCategoryController@deleteRestaurantCategorySlide')->name('admin.deleteRestaurantCategorySlide');
    Route::get('/store-category-slider/disable/{id}', 'RestaurantCategoryController@disableRestaurantCategorySlide')->name('admin.disableRestaurantCategorySlide');
    Route::post('/store-category-slider/new', 'RestaurantCategoryController@newRestaurantCategory')->name('admin.newRestaurantCategory');
    Route::post('/store-category-slider/update', 'RestaurantCategoryController@updateRestaurantCategory')->name('admin.updateRestaurantCategory');
    Route::post('/store-category-slider/save-settings', 'RestaurantCategoryController@saveRestaurantCategorySliderSettings')->name('admin.saveRestaurantCategorySliderSettings');

    Route::post('/create-store-category-slide', 'RestaurantCategoryController@createRestaurantCategorySlide')->name('admin.createRestaurantCategorySlide');
    Route::post('/store-category-slider/edit/position/save', 'RestaurantCategoryController@updateCategorySlidePosition')->name('admin.updateCategorySlidePosition');

    Route::get('/modules', 'ModuleController@modules')->name('admin.modules');
    Route::post('/module/upload', 'ModuleController@uploadModuleZipFile')->name('admin.uploadModuleZipFile');
    Route::post('/module/install', 'ModuleController@installModule')->name('admin.installModule');
    Route::get('/module/disable/{id}', 'ModuleController@disableModule')->name('admin.disableModule');
    Route::get('/module/enable/{id}', 'ModuleController@enableModule')->name('admin.enableModule');

    Route::get('/fix-update-issues', 'AdminController@fixUpdateIssues')->name('admin.fixUpdateIssues');

    Route::get('/update-foodomaa', 'UpdateController@updateFoodomaa')->name('admin.updateFoodomaa');
    Route::get('/update-foodomaa-now', 'UpdateController@updateFoodomaaNow')->name('admin.updateFoodomaaNow');
    Route::post('/update-foodomaa/upload', 'UpdateController@uploadUpdateZipFile')->name('admin.uploadUpdateZipFile');

    Route::post('/force-clear', 'SettingController@forceClear')->name('admin.forceClear');
    Route::post('/clean-everything', 'SettingController@cleanEverything')->name('admin.cleanEverything');

    Route::get('/reports/top-items', 'ReportController@viewTopItems')->name('admin.viewTopItems');
    Route::get('/impersonate/{id}', 'AdminController@impersonate')->name('admin.impersonate');

    Route::get('/backup/files', 'BackupController@filesBackup')->name('admin.filesBackup');
    Route::get('/backup/database', 'BackupController@dbBackup')->name('admin.dbBackup');

    Route::get('/approve-payment-of-order/{order_id}', 'AdminController@approvePaymentOfOrder')->name('admin.approvePaymentOfOrder');

    Route::get('/delete-alerts-junk', 'NotificationController@deleteAlertsJunk')->name('admin.deleteAlertsJunk');

    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('admin.dashboard');

});
/* END Admin Routes */


/* Admin Routes */
Route::group(['prefix' => 'licencer', 'middleware' => ['licencer']], function () {

    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('licencer.dashboard');

    Route::get('/stores', 'Admin\AdminController@restaurants')->name('licencer.restaurants');
    Route::get('/stores/pending-acceptance', 'Admin\AdminController@pendingAcceptance')->name('licencer.pendingAcceptance');
    Route::get('/stores/asked-publish', 'Admin\AdminController@askedPublish')->name('licencer.askedPublish');
    Route::get('/impersonate/{id}', 'AdminController@impersonate')->name('licencer.impersonate');
    
});




/* EXTRAS */
// Route::get('/init', 'InitController@init')->name('init');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
