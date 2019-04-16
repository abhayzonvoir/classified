<?php
/**
 * LaraClassified - Geo Classified Ads Software
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

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Larapen\Admin\app\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;
use DB;
class MenuController extends Controller
{
	/**
	 * ActionController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('demo');
	}
	
	/**
	 * Clear Cache
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function create()
	{
		if(isset($_GET['updatemenu'])){
			
			$allmenulist = $_GET['menulist'];
			$mymenu = json_decode($allmenulist);
			DB::table('navigation')->delete();
		   DB::table('navigation')->insert(['menupages' => $_GET['menulist']]);
			
		}
		$allnavigation = DB::table('navigation')->first();

		return view('admin::menu',['allnavigation' => $allnavigation]);
	}
	
	/**
	 * Test the Ads Cleaner Command
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function callAdsCleanerCommand()
	{
		$errorFound = false;
		
		// Run the Cron Job command manually
		try {
			$exitCode = Artisan::call('ads:clean');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The Cron Job command was successfully run.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	
	/**
	 * Put to maintenance Mode
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function maintenanceDown(Request $request)
	{
		// Form validation
		$rules = [
			'message' => 'max:200',
		];
		$this->validate($request, $rules);
		
		$errorFound = false;
		
		// Go to maintenance with DOWN status
		try {
			if ($request->has('message')) {
				$exitCode = Artisan::call('down', ['--message' => $request->input('message')]);
			} else {
				$exitCode = Artisan::call('down');
			}
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The website has been putted in maintenance mode.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	
	/**
	 * Back to Maintenance Mode
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function maintenanceUp()
	{
		$errorFound = false;
		
		// Restore system UP status
		try {
			$exitCode = Artisan::call('up');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The website has left the maintenance mode.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	public static function getallmenu()
	{
		$allnavigation = DB::table('navigation')->first();
		return $allnavigation; 
		
	}
}
