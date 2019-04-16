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

namespace App\Http\Controllers;

use App\Http\Requests\BottombannerpackageRequest;
use App\Models\Post;
use App\Models\Package;
use App\Models\Bannerpackages;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use App\Http\Controllers\FrontController;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Payment as PaymentHelper;
use DB;
use App\Http\Controllers\Post\Traits\PaymentTrait;
use Illuminate\Http\Request;
class PaymentbannerController extends FrontController
{
	use PaymentTrait;
	
	public $request;
	public $data;
	public $msg = [];
	public $uri = [];
	public $packages;
	public $paymentMethods;
	
	/**
	 * PackageController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->request = $request;
			$this->commonQueries();
			
			return $next($request);
		});
	}
	
	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		// Messages
		if (getSegment(2) == 'create') {
			$this->msg['post']['success'] = t("Your ad has been created.");
		} else {
			$this->msg['post']['success'] = t("Your ad has been updated.");
		}
		$this->msg['checkout']['success'] = t("We have received your payment.");
		$this->msg['checkout']['cancel'] = t("We have not received your payment. Payment cancelled.");
		$this->msg['checkout']['error'] = t("We have not received your payment. An error occurred.");
		
		// Set URLs
		if (getSegment(2) == 'create') {
			$this->uri['previousUrl'] = config('app.locale') . '/posts/create/#entryToken/payment';
			$this->uri['nextUrl'] = config('app.locale') . '/posts/create/#entryToken/finish';
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/posts/create/#entryToken/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/posts/create/#entryToken/payment/success');
		} else {
			$this->uri['previousUrl'] = config('app.locale') . '/posts/#entryId/payment';
			$this->uri['nextUrl'] = config('app.locale') . '/' . trans('routes.v-post', ['slug' => '#title', 'id' => '#entryId']);
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/posts/#entryId/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/posts/#entryId/payment/success');
		}
		
		// Payment Helper init.
		PaymentHelper::$country = collect(config('country'));
		PaymentHelper::$lang = collect(config('lang'));
		PaymentHelper::$msg = $this->msg;
		PaymentHelper::$uri = $this->uri;
		
		// Get Packages
		$this->packages = Package::trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());
		
		// Keep the Post's creation message
		// session()->keep(['message']);
		if (getSegment(2) == 'create') {
			if (session()->has('tmpPostId')) {
				session()->flash('message', t('Your ad has been created.'));
			}
		}
	}
	
	/**
	 * Show the form the create a new ad post.
	 *
	 * @param $postIdOrToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getForm($id)
	{
		$data = [];
		$data['id']=$id; 
		$getallpackage = Bannerpackages::all();
		$data['packages']=$getallpackage;
		return view('bottombanner.packages', $data);
	}
	
	public function fanish(){
		return view('bottombanner.finish');
		
	}	
	public function successbanner(Request $request){
		$parameter = $request->session()->get('params');
		$packageid = $parameter['package_id'];
	    $transcation = $_GET['transaction_id'];
		$amount = $parameter['amount'];
		$postid = $parameter['post_id'];
		$id = \Auth::user()->id;
		
		$user = DB::table('users')->where('id',$id)->first();
		$email = $user->email;
		
		
		$to = $email;
         $subject = "Thanks for Payment";
         
         $message = "<b>We have received your payment</b>";
         $message .= "<p>Your Transcation id :".$transcation."</p>";
          $message .= "<p>Our Team will review Your banner and make it live within 2 hours</p>";
         $header = "From:admin@classifiedzoo.com \r\n";
        // $header .= "Cc:afgh@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
        $to = 'info@classifiedzoo.com';
         $subject = "A customer send request for bottombanner";
         
         $message = "<b>A user send request for bottom banner Details are below</b>";
         $message .= "<p>Your Transcation id :".$transcation."</p>";
           $message .= "<p>your Post url :<a href='/admin/bannerads/".$postid."/edit'>Click here</a></p>";
         $header = "From:admin@classifiedzoo.com \r\n";
        // $header .= "Cc:afgh@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		DB::table('bottombanner')->where('id', $postid)->update(['payment'=>'S','paymenttransation' => $transcation,'packageid'=>$packageid,'amount'=>$amount]);
	 	 return redirect("/bottombanner/fanish");
	
	
	
	
	}	
	public function success(Request $request){
		
		$plugin = load_installed_plugin(strtolower('paypal'));
		
		$post = $_GET;
		$parameter = $request->session()->get('params');
		
		 if (!empty($plugin)) {
                // Send the Payment
                try {
                    return call_user_func($plugin->class . '::sendPaymentbanner', $parameter, $post);
                } catch (\Exception $e) {
                   
                }
            }
		
	}
	
	
	
	
	/**
	 * Store a new ad post.
	 *
	 * @param $postIdOrToken
	 * @param PackageRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postForm($postIdOrToken, BottombannerpackageRequest $request)
	{
		$post = $_POST;
		return $this->bottombannerpayment($post);
		
		/* if (getSegment(2) == 'create') {
			if (!session()->has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::with(['latestPayment'])
				->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', session('tmpPostId'))
				->where('tmp_token', $postIdOrToken)
				->first();
		} else {
			$post = Post::with(['latestPayment'])
				->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', auth()->user()->id)
				->where('id', $postIdOrToken)
				->first();
		}
		
		if (empty($post)) {
			abort(404);
		}
		
		
		$alreadyPaidPackage = false;
		if (!empty($post->latestPayment)) {
			if ($post->latestPayment->package_id == $request->input('package_id')) {
				$alreadyPaidPackage = true;
			}
		}
		
		
		$package = Package::find($request->input('package_id'));
		if (!empty($package)) {
			if ($package->price > 0 && $request->filled('payment_method_id') && !$alreadyPaidPackage) {
				
				return $this->sendPayment($request, $post);
			}
		}
		
		
		if (getSegment(2) == 'create') {
			$request->session()->flash('message', t('Your ad has been created.'));
			$nextStepUrl = config('app.locale') . '/posts/create/' . $postIdOrToken . '/finish';
		} else {
			flash(t("Your ad has been updated."))->success();
			$nextStepUrl = config('app.locale') . '/' . $post->uri . '?preview=1';
		}
		
		
		return redirect($nextStepUrl); */
	}
}
