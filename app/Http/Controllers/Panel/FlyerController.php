<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Flyer;
use App\Order;
use App\Restaurant;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;
use FileUploader;

require_once(base_path('assets/fileuploader/src/php/class.fileuploader.php'));

class FlyerController extends Controller
{
    
    public function flyers()
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurant_id;
       
        $flyers = Flyer::where('restaurant_id', $restaurantIds)->orderBy('id', 'DESC')->where('is_deleted',0)->get();

       
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $count = count($flyers);

        $restaurants = $user->restaurants;
        $agora = Carbon::now();
        return view('panel.flyers', array(
            'flyers' => $flyers,
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
    public function flyers_deleted(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurant_id;
       
        $flyers = Flyer::where('restaurant_id', $restaurantIds)->orderBy('id', 'DESC')->where('is_deleted',1)->get();

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $agora = Carbon::now();
        
        return view('panel.flyers', array(
            'flyers' => $flyers,
            'restaurant_id'=>$user->restaurant_id,
            'restaurant'=>$restaurant,
            'agora'=> $agora,
           
        ));
    }

         /**
     * @param Request $request
     */
    public function flyers_expired(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurant_id;
        $flyers = Flyer::where('restaurant_id', $restaurantIds)->orderBy('id', 'DESC')->where('is_deleted',0)->get();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $agora = Carbon::now();
       

        $flyers2=array();
        foreach($flyers as $flyer){
            if(date('Y-m-d' ,strtotime($flyer->end_date)) < date('Y-m-d' ,strtotime($agora)) ){
                $flyers2[]=$flyer;
            }
          
        }
        return view('panel.flyers', array(
            'flyers' => $flyers2,
           
            'restaurant_id'=>$user->restaurant_id,
            'restaurant'=>$restaurant,
            'agora'=> $agora,
           
        ));
    }

             /**
     * @param Request $request
     */
    public function flyers_nonexpired(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurant_id;
                                                
        $flyers = Flyer::where('restaurant_id', $restaurantIds)->orderBy('id', 'DESC')->where('is_deleted', 0)->get();
        $agora = Carbon::now();
       //dd($flyers);
        $flyers2=array();
        foreach($flyers as $flyer){
            if(date('Y-m-d' ,strtotime($flyer->start_date)) <=date('Y-m-d' ,strtotime($agora)) && date('Y-m-d' ,strtotime($flyer->end_date)) >=date('Y-m-d' ,strtotime($agora)) ){
                $flyers2[]=$flyer;
            }
          
        }

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
     
        return view('panel.flyers', array(
            'flyers' => $flyers2,
            
            'restaurant_id'=>$user->restaurant_id,
            'restaurant'=>$restaurant,
            'agora'=> $agora,
            
        ));
    }
  

       /**
 * @param Request $request
 */
public function saveNewFlyer(Request $request)
{
    // dd($request->all());
    //require(base_path('assets\fileuploader\src\php\class.fileuploader.php'));
    $user = Auth::user();
    
    $flyer = new Flyer();
    $uploadDir = base_path('assets/img/flyers/');
    $encartesDir = base_path('assets/img/flyers/');
    $preloadedFiles='';

    $flyer->name = $request->name;
    $flyer->is_deleted = 0;
    $flyer->restaurant_id=$user->restaurant_id;
    $flyer->user_id=$user->id;
     $flyer->start_date = $request->start_date;
    $flyer->end_date = $request->end_date;
    $files=$request->files;
    //dd($files);

    		// initialize FileUploader
		$FileUploader = new FileUploader('files', array(
			'limit' => null,
			'maxSize' => null,
			'extensions' => null,
			'uploadDir' => $encartesDir,
			'title' => 'auto',
		'files' => null
		));

        $data = $FileUploader->upload();
		//var_dump($data);
		// if uploaded and success
		$imagens=array();
		if ($data['isSuccess'] && count($data['files']) > 0) {
			// get uploaded files
			$uploadedFiles = $data['files'];

			foreach ($uploadedFiles as $item) {
				FileUploader::resize($filename = $item['file'], $width = 550, $height=null, $crop = false, $quality = 95);
			}
			
		}
	//	var_dump($uploadedFiles);

		
		// if warnings
		if ($data['hasWarnings']) {
			// get warnings
			$warnings = $data['warnings'];

		//	echo '<pre>';
		//	print_r($warnings);
		//	echo '</pre>';
			exit;
		}

		// get the fileList
		$fileList = $FileUploader->getFileList();

		// show
		//echo '<pre>';
		//print_r($fileList);
		//echo '</pre>';


		foreach ($fileList as $row){
			$imagens[]=$row['name'];
        }
        
   
        $flyer->image = json_encode($imagens);
    

    
    try {
        $flyer->save();
        if (isset($request->flyer_restaurant_flyer)) {
            $flyer->restaurants()->sync($request->flyer_restaurant_flyer);
       }
        return redirect()->back()->with(['success' => 'Folheto Salvo com Sucesso!']);
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
    public function getEditFlyer($id)
    {
        $user = Auth::user();
        $flyer = Flyer::where('id', $id)->first();
        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $restaurant_id=$user->restaurant_id;
        if ($flyer) {
            return view('panel.editFlyer', array(
                'flyer' => $flyer,
                'restaurants' => $restaurants,
                'restaurant'=>$restaurant,
                'restaurant_id' => $restaurant_id,
            ));
        }
        return redirect()->route('panel.flyers');
    }

   /**
 * @param Request $request
 */
public function updateFlyer(Request $request)
{
    $user = Auth::user();
    $flyer = Flyer::where('id', $request->id)->firstOrFail();
    $uploadDir = base_path('assets/img/flyers/');
    $encartesDir = base_path('assets/img/flyers/');
    $preloadedFiles='';

    $uploadDir2 = '../../assets/img/flyers/';
    
     
	$uploadsFiles1 = $flyer->image;//array_diff(scandir($uploadDir), array('.', '..'));
    if(!empty($uploadsFiles1)){
        $uploadsFiles=json_decode($uploadsFiles1);
        $preloadedFiles=array();
        foreach($uploadsFiles as $file) {
            // skip if directory
            //if(is_dir($uploadDir . $file))
            //	continue;
                    
                    // skip if thumbnail
                //	if (substr($uploadDir . $file, 0, 6) == 'thumb_')
                //			continue;
    
            // add file to our array
            // !important please follow the structure below
            // $preloadedFiles[] = array(
            //     "name" => $file,
            //     "type" => FileUploader::mime_content_type($uploadDir . $file),
            //     "size" => filesize($uploadDir . $file),
            //     "file" => $uploadDir . $file,
            //                 "relative_file" => $uploadDir . $file
            // );

            $preloadedFiles[] = array(
                "name" => $file,
                "type" => FileUploader::mime_content_type($uploadDir2 . $file),
                "size" => filesize($uploadDir . $file),
                "file" => 'https://app.comprabakana.com.br/assets/img/flyers/' . $file.'?t='.time(),
                "local" =>  $uploadDir2 . $file,//.'?t='.time(), // same as in form_upload.php
                "data" => array(
                "url" => $uploadDir2 . $file,//.'?t='.time(), // (optional)
                //"thumbnail" => $uploadDir2 . $file.'?t='.time(), // (optional)
                //"readerForce" => true, // (optional) prevent browser cache
                
                ),
                
                );
            //dd($preloadedFiles);
        }
       // $preloadedFiles=$request->fileuploader-list-files;
    }
			

// initialize FileUploader
$FileUploader = new FileUploader('files', array(
    'limit' => null,
    'maxSize' => null,
    'extensions' => null,
    'uploadDir' => $encartesDir,
    'title' => 'auto',
'files' => $preloadedFiles
));

	// unlink the files
		// !important only for preloaded files
		// you will need to give the array with appendend files in 'files' option of the FileUploader
		//	foreach($FileUploader->getRemovedFiles('file') as $key=>$value) {
		//	unlink($uploadDir . $value['name']);
		//	}

		//echo $list=post('fileuploader-list-files');
		//echo $filess=post('files');
		// call to upload the files
		$data = $FileUploader->upload();
		//var_dump($data);
		// if uploaded and success
		$imagens=array();
		if ($data['isSuccess'] && count($data['files']) > 0) {
			// get uploaded files
            $uploadedFiles = $data['files'];
            //dd($uploadedFiles);

			foreach ($uploadedFiles as $item) {
				FileUploader::resize($filename = $item['file'], $width = 550, $height=null, $crop = false, $quality = 95);
			}
			
		}
	//	var_dump($uploadedFiles);

		
		// if warnings
		if ($data['hasWarnings']) {
			// get warnings
			$warnings = $data['warnings'];

			echo '<pre>';
			print_r($warnings);
			echo '</pre>';
			exit;
		}

		// get the fileList
		$fileList = $FileUploader->getFileList();
//dd($fileList);
		// show
		echo '<pre>';
		print_r($fileList);
		echo '</pre>';


		foreach ($fileList as $row){
			$imagens[]=$row['name'];
        } 
        


        
    $flyer->name = $request->name;
    $flyer->is_active = 1;
     $flyer->start_date = $request->start_date;
    $flyer->end_date = $request->end_date;
    $flyer->is_deleted = 0;
    $flyer->restaurant_id=$user->restaurant_id;
    $flyer->user_id=$user->id;
    $flyer->image = json_encode($imagens);
    
    try {
        $flyer->save();
        if (isset($request->flyer_restaurant_flyer)) {
            $flyer->restaurants()->sync($request->flyer_restaurant_flyer);
       }
        return redirect()->back()->with(['success' => 'Folheto Salvo com Sucesso!']);
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
    public function deleteFlyer($id)
    {
        $flyer = Flyer::where('id', $id)->first();

        if ($flyer) {
            $flyer->is_deleted=1;
            $flyer->is_active=0;
            $flyer->save();
            return redirect()->back()->with(['success' => 'Folheto Excluído com Sucesso']);
        }
        return redirect()->route('panel.flyers');
    }
    
      /**
     * @param $id
     */
    public function restoreFlyer($id)
    {
        $flyer = Flyer::where('id', $id)->first();

        if ($flyer) {
            $flyer->is_deleted=0;
            $flyer->is_active=1;
            $flyer->save();
            return redirect()->back()->with(['success' => 'Folheto Restaurado com Sucesso']);
        }
        return redirect()->route('panel.flyers');
    }

}
