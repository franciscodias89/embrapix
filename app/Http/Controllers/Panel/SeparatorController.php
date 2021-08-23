<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Flyer;
use App\User;
use App\Order;
use App\Restaurant;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;
use FileUploader;


use JWTAuth;

use JWTAuthException;

require_once(base_path('assets/fileuploader/src/php/class.fileuploader.php'));

class SeparatorController extends Controller
{
    
    public function separators()
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;
       
        $separators = User::where('restaurant_id', $restaurant_id)->where('user_type','Separator')->orderBy('id', 'DESC')->where('is_deleted',0)->get();
        $separators_array=array();
        foreach($separators as $separator){
            $orders_running= Order::where('restaurant_id', $restaurant_id)->where('separation_status',12)->where('separator_id',$separator->id)->get();
            $orders_finished= Order::where('restaurant_id', $restaurant_id)->where('separation_status',13)->where('separator_id',$separator->id)->get();
           if(isset($orders_running)){
            $running=count($orders_running);
           }else{
            $running=0; 
           }
           if(isset($orders_finished)){
            $finished=count($orders_finished);
           }else{
            $finished=0;  
           }

            $separator['running']=$running;
            $separator['finished']=$finished;
            $separators_array[]=$separator;

        }
       
        //dd($separators_array);
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $count = count($separators);

        $restaurants = $user->restaurants;
        $agora = Carbon::now();
        return view('panel.separator.separators', array(
            'separators' => $separators_array,
            'count' => $count,
            'agora'=> $agora,
            
            'restaurant_id'=>$user->restaurant_id,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            
        ));
    }

        /**
     * @param Request $request
     */
    public function deletedSeparators(Request $request)
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;
       
        $separators = User::where('restaurant_id', $restaurant_id)->where('user_type','Separator')->orderBy('id', 'DESC')->where('is_deleted',1)->get();
        $separators_array=array();
        foreach($separators as $separator){
            $orders_running= Order::where('restaurant_id', $restaurant_id)->where('separation_status',12)->where('separator_id',$separator->id)->get();
            $orders_finished= Order::where('restaurant_id', $restaurant_id)->where('separation_status',13)->where('separator_id',$separator->id)->get();
           if(isset($orders_running)){
            $running=count($orders_running);
           }else{
            $running=0; 
           }
           if(isset($orders_finished)){
            $finished=count($orders_finished);
           }else{
            $finished=0;  
           }

            $separator['running']=$running;
            $separator['finished']=$finished;
            
                $separators_array[]=$separator;
           
           

        }
       
        //dd($separators_array);
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $count = count($separators);

        $restaurants = $user->restaurants;
        $agora = Carbon::now();
        return view('panel.separator.separators', array(
            'separators' => $separators_array,
            'count' => $count,
            'agora'=> $agora,
            
            'restaurant_id'=>$user->restaurant_id,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            
        ));
    }

         /**
     * @param Request $request
     */
    public function freeSeparators(Request $request)
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;
       
        $separators = User::where('restaurant_id', $restaurant_id)->where('user_type','Separator')->orderBy('id', 'DESC')->where('is_deleted',0)->get();
        $separators_array=array();
        foreach($separators as $separator){
            $orders_running= Order::where('restaurant_id', $restaurant_id)->where('separation_status',12)->where('separator_id',$separator->id)->get();
            $orders_finished= Order::where('restaurant_id', $restaurant_id)->where('separation_status',13)->where('separator_id',$separator->id)->get();
           if(isset($orders_running)){
            $running=count($orders_running);
           }else{
            $running=0; 
           }
           if(isset($orders_finished)){
            $finished=count($orders_finished);
           }else{
            $finished=0;  
           }

            $separator['running']=$running;
            $separator['finished']=$finished;
            if($running==0){
                $separators_array[]=$separator;
            }
           

        }
       
        //dd($separators_array);
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $count = count($separators);

        $restaurants = $user->restaurants;
        $agora = Carbon::now();
        return view('panel.separator.separators', array(
            'separators' => $separators_array,
            'count' => $count,
            'agora'=> $agora,
            
            'restaurant_id'=>$user->restaurant_id,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            
        ));
    }

             /**
     * @param Request $request
     */
    public function workingSeparators(Request $request)
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;
       
        $separators = User::where('restaurant_id', $restaurant_id)->where('user_type','Separator')->orderBy('id', 'DESC')->where('is_deleted',0)->get();
        $separators_array=array();
        foreach($separators as $separator){
            $orders_running= Order::where('restaurant_id', $restaurant_id)->where('separation_status',12)->where('separator_id',$separator->id)->get();
            $orders_finished= Order::where('restaurant_id', $restaurant_id)->where('separation_status',13)->where('separator_id',$separator->id)->get();
           if(isset($orders_running)){
            $running=count($orders_running);
           }else{
            $running=0; 
           }
           if(isset($orders_finished)){
            $finished=count($orders_finished);
           }else{
            $finished=0;  
           }

            $separator['running']=$running;
            $separator['finished']=$finished;
            if($running>0){
                $separators_array[]=$separator;
            }
           

        }
       
        //dd($separators_array);
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $count = count($separators);

        $restaurants = $user->restaurants;
        $agora = Carbon::now();
        return view('panel.separator.separators', array(
            'separators' => $separators_array,
            'count' => $count,
            'agora'=> $agora,
            
            'restaurant_id'=>$user->restaurant_id,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            
        ));
    }
  
       /**
     * @param $email
     * @param $password
     * @return mixed
     */
    private function getToken($email, $password)
    {
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid..',
                    'token' => $token,
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
    }

       /**
 * @param Request $request
 */
public function saveNewSeparator(Request $request)
{

    $user = Auth::user();

        $restaurant_id = $user->restaurant_id;

    try {
        $user_test = \App\User::where('email', $request->email)->get()->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'delivery_pin' => strtoupper(str_random(5)),
            'password' => \Hash::make($request->password),
        ]);

        $token = self::getToken($request->email, $request->password); // generate user token

        if (!is_string($token)) {
            return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
        }

        
        $user->auth_token = $token; // update user token

        $user->restaurant_id = $restaurant_id; 
        $user->user_type='Separator';
        $user->restaurants()->sync($user->restaurant_id);
        $user->save();

        $user->assignRole('Separator');

        return redirect()->back()->with(['success' => 'Separador Salvo com Sucesso!']);
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
    public function getEditSeparator($id)
    {
        $user = Auth::user();
        $separator = User::where('id', $id)->first();
        
        
        
        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $restaurant_id=$user->restaurant_id;
        if ($separator) {
            return view('panel.separator.editSeparator', array(
                'separator' => $separator,
                'restaurants' => $restaurants,
                'restaurant'=>$restaurant,
                'restaurant_id' => $restaurant_id,
            ));
        }
        return redirect()->route('panel.separators');
    }

   /**
 * @param Request $request
 */
public function updateSeparator(Request $request)
{
    $user_restaurant = Auth::user();
    
    
  $user=User::where('id',$request->id)->first();

    $user->name=$request->name;
    $user->email=$request->email;
    $user->phone=$request->phone;

    if(!empty($request->password)){
        $user->password=\Hash::make($request->password);
    }
    
    
  
    $user->save();

    try {
        $user->save();
        
        return redirect()->back()->with(['success' => 'Usuário Salvo com Sucesso!']);
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
    public function deleteSeparator($id)
    {
        $separator = User::where('id', $id)->first();

        if ($separator) {
            $separator->is_deleted=1;
            $separator->is_active=0;
            $separator->save();
            return redirect()->back()->with(['success' => 'Separador Excluído com Sucesso']);
        }
        return redirect()->route('panel.separators');
    }
    
      /**
     * @param $id
     */
    public function restoreSeparator($id)
    {
        $separator = User::where('id', $id)->first();

        if ($separator) {
            $separator->is_deleted=0;
            $separator->is_active=1;
            $separator->save();
            return redirect()->back()->with(['success' => 'Usuário Restaurado com Sucesso']);
        }
        return redirect()->route('panel.separators');
    }

}
