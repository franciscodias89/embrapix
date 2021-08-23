<?php

namespace App\Http\Controllers\Datatables;

use App\Item;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class ItemsDatatable
{


    public function itemsDataTable()
    {
        // sleep(5000);
        $items = Item::with('item_category');

        return Datatables::of($items)
            ->editColumn('ean', function ($item) {
                $html = '';
               
                $html .= '<a href="' . route('restaurant.get.editItem', $item->id) . '"target="_blank" class="linked-item" data-popup="tooltip" title="" data-placement="bottom" data-original-title="Abrir Produto">' . $item->ean . '</a>';

                return $html;

            })
            ->editColumn('created_at', function ($item) {
                return '<span data-popup="tooltip" data-placement="left" title="' . $item->created_at->diffForHumans() . '">' . $item->created_at->format('d-m-Y - h:i') . '</span>';
            })

            ->addColumn('name', function ($item) {
                /* $html = '';
                $html .='<div style="word-wrap: break-word">'.$item->name.'</div>'; */
                    return $item->name;//substr($item->name, 0, 80).' (...)'; 
                
            })
            
            ->addColumn('item_category', function ($item) {
                /* $html = '';
                $html .='<div style="word-wrap: break-word">'.$item->name.'</div>'; */
                    return $item->item_category->name;//substr($item->name, 0, 80).' (...)'; 
                
            })

            ->addColumn('image', function ($item) {
               
                                $url = $item->image;
                                $html = '';
                                 if(substr($url, 0, 4) == "http"){
                                        
                                    $html .=   '<img src="'. $item->image . '" alt="' . $item->name . '" height="80" width="80" style="border-radius: 0.275rem;">';
                                     
                                 } else {
                                    $html .=   '<img src="'. substr(url("/"), 0, strrpos(url("/"), '/')). ''. $item->image.'" alt="'. $item->name .'" height="80" width="80" style="border-radius: 0.275rem;">';
                         
                                 } 

                return $html;
            
        })

            ->editColumn('is_active', function ($item) {

                $html = '';

                if ($item->is_active == 1 ) {
                    
                        $html .= '<div class="orderDatatable-status d-inline-block">
                        <span class="order-bg-opacity-success  text-success rounded-pill active">Ativo</span>
                    </div>';
                    
                } else {
                    $html .= '<div class="orderDatatable-status d-inline-block">
                    <span class="order-bg-opacity-danger  text-danger rounded-pill active">Desativado</span>
                </div>';
                }
                return $html;
            })
            ->editColumn('price', function ($item) {
                return 'R$ ' . number_format($item->price, 2, ',', '.');
            })

          
            ->addColumn('action', function ($item) {

                $html = '<button class="btn btn-sm btn-default btn-primary " style="height:50px; width:70px" type="button"  aria-haspopup="true" aria-expanded="false">
                                        <span style="align:center">Editar</span>
                                    </button>';
                //$html = '<a href="' . route('restaurant.get.editItem', $item->id) . '" class="btn btn-sm btn-primary"> Editar</a>';
                return $html;
            })
          
            ->rawColumns(['ean', 'name', 'item_category','image', 'is_active', 'action', 'created_at', 'price'])
            ->make(true);
    }
}
