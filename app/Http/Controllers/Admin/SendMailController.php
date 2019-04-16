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
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Http\Controllers\Redirect;

class SendMailController extends Controller
{
	
	public function index()
	{
		$this->data['title'] = 'Send Mail';
		$users = DB::table('users')->get();
		//print_r($users);

		return view('send_mail.index',$this->data, ['user_data'=>$users]);
	}
	public function sub_mail()
	{
		DB::enableQueryLog();
		$user_ID = $_REQUEST['usr'];
		$u_id = implode(',',$user_ID);
		$subject = $_REQUEST['subj'];
        //print_r($u_id); exit;
		$content = $_REQUEST['description'];
        //print_r($u_id); exit();
 $qr = DB::select( DB::raw("SELECT * FROM users WHERE id IN (".$u_id.")") );
        // $users3 = DB::table('users')
        //              ->whereIn('id', array($u_id))
        //              ->get();
        //              dd(
        //     DB::getQueryLog()
        // );
//print_r($qr); exit();
foreach ($qr as $value) {
   //print_r($value->email) ;   
   $vr = $value->email;              
$sam = array('name'=>"Admin", 'content'=>$content);
   //print_r($subject); exit();
      Mail::send(['html'=>'send_mail.mail'], $sam, function($message)use ($subject , $vr) {
         $message->to($vr, 'Admin')->subject
            ($subject);
         $message->from('sameekshasingh28199@gmail.com','ClassifiedZoo');
      });
		DB::table('email_backup')->insert(
    ['user_id' => $value->id ,'subj'=>$subject, 'description' => $content]
); 
//print_r($val); exit;
}

 
		$success = 'Mail sent Successfully';
		 return redirect()->back()->with('message', $success);
}
public function view_email_list()
	{
	$vl = DB::table('email_backup')->join('users', 'users.id', '=', 'email_backup.user_id')->select('users.*', 'email_backup.subj','email_backup.description')->get();

	return view('send_mail.view_mails',['m_val'=>$vl]);
	}
	
}
