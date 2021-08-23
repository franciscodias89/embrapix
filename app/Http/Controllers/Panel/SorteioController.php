<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Sorteio;
use App\Order;
use App\Restaurant;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Image;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;

class SorteioController extends Controller
{
    /**
     * @param Request $request
     */
    public function sorteios(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();
       
        $sorteios = Sorteio::whereHas('restaurants', function($query) use ($restaurantIds) {
            $query->whereIn('restaurant_id', $restaurantIds);
        })->orderBy('id', 'DESC')->paginate(20);

        //dd($flyers);

        $count = $sorteios->total();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $restaurants = Restaurant::all();
        $todaysDate = Carbon::now()->format('m-d-Y');
        return view('panel.sorteios', array(
            'sorteios' => $sorteios,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'todaysDate' => $todaysDate,
        ));
    }

  

    /**
     * @param Request $request
     */
    public function saveNewSorteio(Request $request)
    {   
        $user = Auth::user();
        $sorteio = new Sorteio();
        $sorteio->name = $request->name;
        $sorteio->restaurant_id = $user->restaurant_id;
        $sorteio->description = $request->description;
        $sorteio->expiry_date = Carbon::parse($request->expiry_date)->format('Y-m-d H:i:s');
        $sorteio->min_subtotal =  str_replace(",",".", $request->min_subtotal);
        $sorteio->is_active = true;
        $image = $request->file('image');
            $rand_name = time() . str_random(10);
            $filename = $rand_name . '.jpg';
           /*  Image::make($image)
           /*  ->resizeCanvas(400, 400, 'center', false, 'ffffff') 
            /* ->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();                 
            }) 
            ->canvas(400, 400, '#ffffff')
                ->save(base_path('assets/img/sorteios/' . $filename), config('settings.uploadImageQuality '), 'jpg');

 */

            // creating a canvas
            $canvas = Image::canvas(400, 400);

            // pass the right full path to the file. Remember that $path is a path inside app/public !
            $image = Image::make($image)->resize(400, 400, 
                function ($constraint) {
                    $constraint->aspectRatio();
            });

            $canvas->insert($image, 'center');

            // pass the full path. Canvas overwrites initial image with a logo
            $canvas->save(base_path('assets/img/sorteios/' . $filename), config('settings.uploadImageQuality '), 'jpg');




    
            $sorteio->image = '/assets/img/sorteios/' . $filename;
 
        try {
            $sorteio->save();
            $sorteio->restaurants()->sync($user->restaurant_id);
            return redirect()->back()->with(['success' => 'Sorteio Criado com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

    /**
     * @param $id
     */
    public function getEditSorteio($id)
    {
        $user = Auth::user();
        $restaurantId = $user->restaurant_id;
        $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
        $sorteio = Sorteio::where('id', $id)->first();
        $restaurants = Restaurant::all();
        if ($sorteio) {
            return view('panel.editSorteio', array(
                'sorteio' => $sorteio,
                'restaurant'=>$restaurant,
                'restaurants' => $restaurants,
            ));
        }
        return redirect()->route('panel.sorteios');
    }

    /**
     * @param Request $request
     */
    public function updateSorteio(Request $request)
    {
        $user = Auth::user();
        $sorteio = Sorteio::where('id', $request->id)->first();

        if ($sorteio) {

            $sorteio->name = $request->name;
            $sorteio->description = $request->description;
            $sorteio->expiry_date = Carbon::parse($request->expiry_date)->format('Y-m-d H:i:s');
            $sorteio->min_subtotal =  str_replace(",",".", $request->min_subtotal);
            $sorteio->is_active = true;

            if($request->file('image')){
                
            $image = $request->file('image');
                $rand_name = time() . str_random(10);
                $filename = $rand_name . '.jpg';
               /*  Image::make($image)
               /*  ->resizeCanvas(400, 400, 'center', false, 'ffffff') 
                /* ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();                 
                }) 
                ->canvas(400, 400, '#ffffff')
                    ->save(base_path('assets/img/sorteios/' . $filename), config('settings.uploadImageQuality '), 'jpg');
    
     */
    
                // creating a canvas
                $canvas = Image::canvas(400, 400);
    
                // pass the right full path to the file. Remember that $path is a path inside app/public !
                $image = Image::make($image)->resize(400, 400, 
                    function ($constraint) {
                        $constraint->aspectRatio();
                });
    
                $canvas->insert($image, 'center');
    
                // pass the full path. Canvas overwrites initial image with a logo
                $canvas->save(base_path('assets/img/sorteios/' . $filename), config('settings.uploadImageQuality '), 'jpg');
    
    
    
    
        
                $sorteio->image = '/assets/img/sorteios/' . $filename;
      
            }
   
        
        try {
            $sorteio->save();
            $sorteio->restaurants()->sync($user->restaurant_id);
                return redirect()->back()->with(['success' => 'Sorteio Atualizado com Sucesso!']);
            } catch (\Illuminate\Database\QueryException $qe) {
                return redirect()->back()->with(['message' => $qe->getMessage()]);
            } catch (Exception $e) {
                return redirect()->back()->with(['message' => $e->getMessage()]);
            } catch (\Throwable $th) {
                return redirect()->back()->with(['message' => $th]);
            }
        }
    }

    /**
     * @param $id
     */
    public function deleteSorteio($id)
    {
        $coupon = Coupon::where('id', $id)->first();

        if ($coupon) {
            $coupon->delete();
            return redirect()->back()->with(['success' => 'Coupon Deleted']);
        }
        return redirect()->route('admin.coupons');
    }
    
}
