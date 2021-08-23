<link rel="stylesheet" href="{{ asset('vendor_assets/css/bootstrap/'.(Session::get('layout')=='rtl' ? 'bootstrap-rtl.css' : 'bootstrap.css')) }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/fullcalendar@5.2.0.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/jquery-jvectormap-2.0.5.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/jquery.mCustomScrollbar.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/leaflet.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/line-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/MarkerCluster.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/MarkerCluster.Default.css') }}">
 <link rel="stylesheet" href="{{ asset('vendor_assets/css/select2.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('vendor_assets/css/slick.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/star-rating-svg.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/trumbowyg.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor_assets/css/wickedpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/'.(Session::get('layout')=='rtl' ? 'style-rtl.css' : 'style.css')) }}">

<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

<link type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>

<link type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap.min.css" rel="stylesheet"/>

<link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />


  


<style>
  .jGrowl-notification {
  margin-bottom: .625rem;
  width: 20rem;
  text-align: left;
  color: #f3f4f7;
  display: none;
  box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.1);
}
.bg-success {
  background-color: #069150 !important;
}

.userDatatable table td {
  border-top: 0;
  border-bottom: none;
  padding: 10px 20px;
  vertical-align: middle;
  white-space: nowrap;
  font-size: 15px;
}

.userDatatable .table-hover tbody tr:hover {
    background: #f8f9fb;
}

  .hidden{ 
  display: none;
}

.form-control {
       border: 1px solid #e3e6ef;
}

.sidebar.collapsed .sidebar__menu-group li a {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    padding: 15px 0;
    justify-content: center;
    margin: 0 auto;
}
.sidebar__menu-group ul.sidebar_nav li > a .nav-icon {
    color: #adb4d2;
    display: inline-block;
    margin-right: 20px;
    width: 20px;
    transition: all 0.3s ease;
}

/* .jGrowl{z-index:1070;position:absolute}body>.jGrowl{position:fixed}.jGrowl.top-left{left:1.25rem;top:1.25rem}.jGrowl.top-center{left:50%;top:1.25rem;margin-left:-10rem}.jGrowl.top-right{right:1.25rem;top:1.25rem}.jGrowl.center{top:40%;width:20rem;left:50%;margin-left:-10rem;margin-top:-1.87502rem}.jGrowl.center .jGrowl-closer,.jGrowl.center .jGrowl-notification{margin-left:auto;margin-right:auto}.jGrowl.bottom-left{left:1.25rem;bottom:1.25rem}.jGrowl.bottom-center{left:50%;bottom:1.25rem;margin-left:-10rem}.jGrowl.bottom-right{right:1.25rem;bottom:1.25rem}@media print{.jGrowl{display:none}}.jGrowl-notification{margin-bottom:.625rem;width:20rem;text-align:left;display:none;box-shadow:0 .25rem .5rem rgba(0,0,0,.1)}.jGrowl-notification .jGrowl-header{font-size:.9375rem;margin-bottom:.3125rem}.jGrowl-notification .jGrowl-header:empty{margin:0}.jGrowl-notification .jGrowl-close{font-weight:400;background:0 0;border:0;font-size:1.25003rem;cursor:pointer;line-height:1;padding:0;float:right;color:inherit;outline:0;margin-left:.625rem;opacity:.75;transition:opacity ease-in-out .15s}@media (prefers-reduced-motion:reduce){.jGrowl-notification .jGrowl-close{transition:none}}.jGrowl-notification .jGrowl-close:hover{opacity:1}.jGrowl-closer{padding:.3125rem 0;cursor:pointer;margin-top:.3125rem;text-align:center;background-color:#fff;width:20rem;border:1px solid #ddd;border-radius:.1875rem}
 */
.ui-pnotify{top:1.25rem;right:1.25rem;position:absolute;height:auto;z-index:2;border-radius:.1875rem;box-shadow:0 .25rem .5rem rgba(0,0,0,.1)}body>.ui-pnotify{position:fixed;z-index:1070}.ui-pnotify.alert-rounded>.ui-pnotify-container{border-radius:100px}.ui-pnotify[class*=bg-]>.ui-pnotify-container{background-color:inherit;border-color:transparent;color:#fff}.ui-pnotify[class*=alpha-]>.ui-pnotify-container,.ui-pnotify[class*=text-]>.ui-pnotify-container{background-color:inherit;border-color:inherit;color:inherit}.ui-pnotify.stack-bottom-left,.ui-pnotify.stack-top-left{left:1.25rem;right:auto}.ui-pnotify.stack-bottom-left,.ui-pnotify.stack-bottom-right{bottom:1.25rem;top:auto}.ui-pnotify.stack-modal{left:50%;right:auto;margin-left:-10rem}.ui-pnotify.stack-custom-right{top:auto;left:auto;bottom:15rem;right:15rem}.ui-pnotify.stack-custom-left{top:15rem;left:15rem;right:auto;bottom:auto}.ui-pnotify.stack-custom-top{right:0;left:0;top:0}.ui-pnotify.stack-custom-bottom{right:0;left:0;bottom:0;top:auto}.ui-pnotify.ui-pnotify-in{display:block!important}.ui-pnotify.ui-pnotify-move{transition:left .5s ease,top .5s ease,right .5s ease,bottom .5s ease}.ui-pnotify.ui-pnotify-fade-slow{opacity:0;transition:opacity linear .6s}.ui-pnotify.ui-pnotify-fade-slow.ui-pnotify.ui-pnotify-move{transition:opacity .6s linear,left .5s ease,top .5s ease,right .5s ease,bottom .5s ease}.ui-pnotify.ui-pnotify-fade-normal{opacity:0;transition:opacity linear .4s}.ui-pnotify.ui-pnotify-fade-normal.ui-pnotify.ui-pnotify-move{transition:opacity .4s linear,left .5s ease,top .5s ease,right .5s ease,bottom .5s ease}.ui-pnotify.ui-pnotify-fade-fast{transition:opacity .2s linear;opacity:0}.ui-pnotify.ui-pnotify-fade-fast.ui-pnotify.ui-pnotify-move{transition:opacity .2s linear,left .5s ease,top .5s ease,right .5s ease,bottom .5s ease}.ui-pnotify.ui-pnotify-fade-in{opacity:1}.ui-pnotify-container{padding:.9375rem 1.25rem;height:100%;position:relative;left:0;margin:0;border-radius:.1875rem}.ui-pnotify-container::after{display:block;clear:both;content:""}.ui-pnotify-container.ui-pnotify-sharp{border-radius:0}.ui-pnotify-title{display:block;margin-top:0;margin-bottom:.3125rem;font-size:.9375rem}.ui-pnotify-text{display:block}.ui-pnotify-icon{display:block;float:left;line-height:1}.ui-pnotify-icon>[class^=icon-]{margin-top:.25003rem;margin-right:.625rem}.ui-pnotify-closer,.ui-pnotify-sticker{float:right;margin-left:.625rem;margin-top:.25003rem;line-height:1;outline:0}.ui-pnotify-modal-overlay{background-color:rgba(0,0,0,.5);top:0;left:0;position:absolute;z-index:1;width:100%;height:100%}body>.ui-pnotify-modal-overlay{position:fixed;z-index:1040}.brighttheme{border:1px solid}.ui-pnotify[class*=bg-]>.brighttheme{background-color:inherit;border-color:inherit;color:inherit}.brighttheme-notice{background-color:#fff3e0;border-color:#ff9800;color:#bf360c}.brighttheme-info{background-color:#e1f5fe;border-color:#03a9f4;color:#01579b}.brighttheme-success{background-color:#e8f5e9;border-color:#4caf50;color:#1b5e20}.brighttheme-error{background-color:#ffebee;border-color:#f44336;color:#b71c1c}.brighttheme-icon-closer,.brighttheme-icon-sticker{position:relative;display:inline-block;outline:0;width:.75rem;height:.75rem}.brighttheme-icon-closer:after,.brighttheme-icon-sticker:after{content:'';font-family:icomoon;font-size:.75rem;display:block;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.brighttheme-icon-closer:after{content:""}.brighttheme-icon-sticker:after{content:""}.brighttheme-icon-sticker.brighttheme-icon-stuck:after{content:""}.ui-pnotify[class*=alert-styled-]{border-width:0;padding:0}.ui-pnotify.alert-styled-left .brighttheme{border-left-width:2.875rem}.ui-pnotify.alert-styled-left:after{left:0}.ui-pnotify.alert-styled-right .brighttheme{border-right-width:2.875rem}.ui-pnotify.alert-styled-right:after{right:0}.brighttheme .ui-pnotify-action-bar input,.brighttheme .ui-pnotify-action-bar textarea{display:block;width:100%;border:1px solid #ddd;background-color:#fff;margin-bottom:1.25rem!important;color:#333;padding:.4375rem .875rem;outline:0}.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar input,.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar textarea{border-color:transparent;color:#fff}.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar input::-webkit-input-placeholder,.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar textarea::-webkit-input-placeholder{color:#fff;opacity:1}.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar input::-moz-placeholder,.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar textarea::-moz-placeholder{color:#fff;opacity:1}.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar input:-ms-input-placeholder,.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar textarea:-ms-input-placeholder{color:#fff;opacity:1}.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar input::-ms-input-placeholder,.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar textarea::-ms-input-placeholder{color:#fff;opacity:1}.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar input::placeholder,.ui-pnotify[class*=bg-] .brighttheme .ui-pnotify-action-bar textarea::placeholder{color:#fff;opacity:1}.ui-pnotify-history-container{position:absolute;top:0;right:1.25rem;border-top:none;padding:0;z-index:1070;border-top-left-radius:0;border-top-right-radius:0}.ui-pnotify-history-container.ui-pnotify-history-fixed{position:fixed}.ui-pnotify-history-container .ui-pnotify-history-header{text-align:center;margin-bottom:.3125rem}.ui-pnotify-history-container button{cursor:pointer;display:block;width:100%}.ui-pnotify-history-container .ui-pnotify-history-pulldown{display:block;margin:0 auto}@media (max-width:767.98px){.ui-pnotify-mobile-able.ui-pnotify{position:fixed;top:0;right:0;left:0;width:auto!important;font-smoothing:antialiased}.ui-pnotify-mobile-able.ui-pnotify .ui-pnotify-shadow{border-bottom-width:5px;box-shadow:none}.ui-pnotify-mobile-able.ui-pnotify.stack-bottom-left,.ui-pnotify-mobile-able.ui-pnotify.stack-top-left{left:0;right:0}.ui-pnotify-mobile-able.ui-pnotify.stack-bottom-left,.ui-pnotify-mobile-able.ui-pnotify.stack-bottom-right{left:0;right:0;bottom:0;top:auto}.ui-pnotify-mobile-able.ui-pnotify.stack-bottom-left .ui-pnotify-shadow,.ui-pnotify-mobile-able.ui-pnotify.stack-bottom-right .ui-pnotify-shadow{border-top-width:5px;border-bottom-width:1px}.ui-pnotify-mobile-able.ui-pnotify.ui-pnotify-nonblock-fade{opacity:.2}.ui-pnotify-mobile-able.ui-pnotify.ui-pnotify-nonblock-hide{display:none!important}.ui-pnotify-mobile-able .ui-pnotify-container{border-radius:0}}.jGrowl{z-index:1070;position:absolute}body>.jGrowl{position:fixed}.jGrowl.top-left{left:1.25rem;top:1.25rem}.jGrowl.top-center{left:50%;top:1.25rem;margin-left:-10rem}.jGrowl.top-right{right:1.25rem;top:1.25rem}.jGrowl.center{top:40%;width:20rem;left:50%;margin-left:-10rem;margin-top:-1.87502rem}.jGrowl.center .jGrowl-closer,.jGrowl.center .jGrowl-notification{margin-left:auto;margin-right:auto}.jGrowl.bottom-left{left:1.25rem;bottom:1.25rem}.jGrowl.bottom-center{left:50%;bottom:1.25rem;margin-left:-10rem}.jGrowl.bottom-right{right:1.25rem;bottom:1.25rem}@media print{.jGrowl{display:none}}.jGrowl-notification{margin-bottom:.625rem;width:20rem;text-align:left;display:none;box-shadow:0 .25rem .5rem rgba(0,0,0,.1)}.jGrowl-notification .jGrowl-header{font-size:.9375rem;margin-bottom:.3125rem}.jGrowl-notification .jGrowl-header:empty{margin:0}.jGrowl-notification .jGrowl-close{font-weight:400;background:0 0;border:0;font-size:1.25003rem;cursor:pointer;line-height:1;padding:0;float:right;color:inherit;outline:0;margin-left:.625rem;opacity:.75;transition:opacity ease-in-out .15s}@media (prefers-reduced-motion:reduce){.jGrowl-notification .jGrowl-close{transition:none}}.jGrowl-notification .jGrowl-close:hover{opacity:1}.jGrowl-closer{padding:.3125rem 0;cursor:pointer;margin-top:.3125rem;text-align:center;background-color:#fff;width:20rem;border:1px solid #ddd;border-radius:.1875rem}

/* .select2-container--bootstrap .select2-selection {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
   box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); 
  background-color: #fff;
  border: 1px solid #f3f4f7;
  border-radius: 4px;
  color: #555555;
  font-size: 14px;
  outline: 0;
} */

.img-flag {
  width: 50px;
  height: 50px;
  object-fit: contain;
}

/* .select2-hidden-accessible.parsley-error ~ ul ~ .select2-selection.select2-selection--multiple {
   border-color: #f34943 !important; 
}

.select2-hidden-accessible.parsley-error ~ ul ~ .select2-selection .select2-selection--multiple {
   border-color: #43d39e !important;
} */
@media (min-width: 992px) {

.modal-lg,
.modal-xl {
  max-width: 1200px;
}
}

.imagelogo {
  display: block;
  border-radius: 5px;
  border: 1px solid #ddd;
  background-image: url(https://effetech.com.br/assets/img/icone_logoCliente.png);
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center;
  height: 202px;
  width: 204px;
}

img.slider-preview-image {
  width: 200px;
  height: 200px;
  object-fit: contain;
  background-color: white;
}

  
.header-top {
   
    z-index: 1039;
   
}

.parsley-errors-list {
  margin: 0;
  padding: 0;
}

.parsley-errors-list > li {
  list-style: none;
  color: #ff5c75;
  margin-top: 10px;
  font-size: smaller;
  padding: 4px 7px 4px 28px;
  position: relative;
  display: inline-block;
  background-color: rgba(255, 92, 117, 0.2);
  border-radius: 7px;
}

.parsley-errors-list > li:before {
  content: "\EBEE";
  font-family: "Font Awesome 5 Free";
  position: absolute;
  left: 8px;
  top: 4px;
}

.parsley-errors-list > li:after {
  content: "";
  border: 8px solid transparent;
  border-bottom-color: rgba(255, 92, 117, 0.2);
  position: absolute;
  left: 14px;
  top: -16px;
}

.parsley-error {
  border-color: #ff5c75;
}

.parsley-success {
  border-color: #43d39e;
}

.edit-profile__body label {
    text-transform: none;
}
.card .card-header {

    text-transform: none;

}
.edit-profile__body .form-group .form-control::-moz-placeholder {
  font-size: 14px;
  line-height: 1.7857142857;
  font-weight: 400;
  color: #9ba1c5;
}

.edit-profile__body .form-group .form-control:-ms-input-placeholder {
  font-size: 14px;
  line-height: 1.7857142857;
  font-weight: 400;
  color: #9ba1c5;
}

.edit-profile__body .form-group .form-control::placeholder {
  font-size: 14px;
  line-height: 1.7857142857;
  font-weight: 400;
  color: #9ba1c5;
}
.fa-question-circle:before {
    content: "\f059";
    color: #dcbe50;
    font-size: 13.5px;
}
/* 
  .select2-container--bootstrap .select2-selection--single { height: 44px; line-height: 1.82857143; }
.select2-container--bootstrap .select2-search--dropdown .select2-search__field { font-size: 16px;}
.select2-container--bootstrap .select2-results > .select2-results__options { max-height: 300px; }

  .select2-container--bootstrap .select2-selection {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  background-color: #fff;
  border: 1px solid #e2e7f1;
  border-radius: 4px;
  color: #555555;
  font-size: 14px;
  outline: 0;
} */
</style>

