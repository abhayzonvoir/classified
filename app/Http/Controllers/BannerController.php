<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers;
use App\Helpers\Arr;
use App\Helpers\DBTool;
use App\Models\Post;
use App\Models\Category;
use App\Models\bottombanner;
use App\Models\HomeSection;
use App\Models\SubAdmin1;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Bannerpackages;
use Illuminate\Support\Facades\DB;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use Illuminate\Http\Request;
use App\Http\Controllers\Post\Traits\PaymentTrait;

class BannerController extends FrontController
{
	use PaymentTrait;
	/**
	 * HomeController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Check Country URL for SEO
		$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		view()->share('countries', $countries);
	}
	public function create(){
	$getallpackage = Bannerpackages::all();
		
	$bdraw =  $totalposts = DB::table('pages')->where('id','7')->first();
    return view('bottombanner.create',compact('bdraw'),compact('getallpackage'));	
		
		
	}
	public function savebanner(Request $request){
	$request->validate([
            'pictures' => 'required',
			'package_id'=>'required'
			
        ]);	
		
		
	 $countryCode = config('country.code');
	 if(!empty($request->file('pictures'))){
     $file = $request->file('pictures');
     $filename =$file->getClientOriginalName();
   
      //Move Uploaded File
       $destinationPath = 'storage/app/';
       $file->move($destinationPath,$file->getClientOriginalName());
	   $id = \Auth::user()->id;
	   $bottombanner = new bottombanner();
       $bottombanner->bannername = $file->getClientOriginalName();
	   //$bottombanner->bannerlink = $_POST['bannerlink'];
	   //$bottombanner->content = $_POST['content'];
	   $bottombanner->country  = $countryCode;
	   $bottombanner->payment = 'P';
       $bottombanner->status = 'D'; 
       $bottombanner->userid = $id;
	   
        $banner = $bottombanner->save();
	 
	  $lastinsertedid = $bottombanner->id;

	  
	 $package_id = $_POST['package_id'];
	 $_POST['post_id'] =	 $lastinsertedid;
	  $post = $_POST;
	return $this->bottombannerpayment($post);
	  //return redirect("/bottombanner/$lastinsertedid/payment?package_id=$package_id");
     }
		  
		
	}
}
