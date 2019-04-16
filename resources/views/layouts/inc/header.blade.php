<?php
use \App\Http\Controllers\admin\MenuController;
use \App\Http\Controllers\HomeController;
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.other.cache_expiration', 60);
$defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    $defaultLang = \App\Models\Language::where('default', 1)->first();
    return $defaultLang;
});

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
	if (!empty(config('country.code'))) {
		if (\App\Models\Country::where('active', 1)->count() > 1) {
			$multiCountriesIsEnabled = true;
			$multiCountriesLabel = 'title="' . t('Select a Country') . '"';
		}
	}
}

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
	$logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
}
?>

<style>
.submenulink {
	font-size: 14px !important;
}
.dropdown:hover .dropdown-content {display: block;}
.submenulink{
	color: #2B2D2E;
	
	transition: .1s;
	transition-timing-function: ease-out;
}
.submenulink:hover {
	
	font-weight: 700;
}


.dropdown-toggle:hover .dropdown-menu {display: block;}


.bottomnavigation .navbar-default {

	
	min-height: 80px;
}
.bottomnavigation .navbar-brand>img {
  padding-top: 11px;
  width: 130px;
  margin-left: 60px;
}
.bottomnavigation .navbar-default {
	color: #fff;
	background-color: #CB171E;
	border-color: #000000;
}
.bottomnavigation  .navbar-default .navbar-collapse, .navbar-default .navbar-form {
	border-color: #e7e7e7;
	display: table !important;
	margin: 0 auto;
}
.bottomnavigation .navbar-default .navbar-nav > li > a {
	border-radius: 3px;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	color: #fff;
	font-size: 17px;
	height: 40px;
	line-height: 1;
	padding: 12px 10px;
	font-weight: 700;
}
.bottomnavigation .navbar-brand {
    height: auto;
    margin: 0;
    padding: 0;
    margin-right: 20px;
}
.bottomnavigation .navbar-default{
color: #fff;
background-color: #C3171E;
border-color: #000000;
}
.bottomnavigation.navbar-default .navbar-nav > li > a{
	color:#fff;
}
.bottomnavigation.navbar-default .navbar-nav > .dropdown > a .caret{
	border-top-color: #fff;
    border-bottom-color: #fff;
}
.bottomnavigation.navbar-default .navbar-brand{
	color:#fff;
}
.menu-large {
  position: static !important;
}
.megamenu{
  padding: 20px 0px;
  width:100%;
}
.megamenu> li > ul {
  padding: 0;
  margin: 0;
}
.megamenu> li > ul > li {
  list-style: none;
}
.megamenu> li > ul > li > a {
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: normal;
  line-height: 1.428571429;
  color: #333333;
  white-space: normal;
}
.megamenu> li ul > li > a:hover,
.megamenu> li ul > li > a:focus {
  text-decoration: none;
  color: #262626;
  background-color: #f5f5f5;
}
.megamenu.disabled > a,
.megamenu.disabled > a:hover,
.megamenu.disabled > a:focus {
  color: #999999;
}
.navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover {
  color: #00A7E8;
}
.megamenu.disabled > a:hover,
.megamenu.disabled > a:focus {
  text-decoration: none;
  background-color: transparent;
  background-image: none;
  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
  cursor: not-allowed;
}
.megamenu.dropdown-header {
  color: #428bca;
  font-size: 18px;
}
@media (max-width: 768px) {
	.bottomnavigation{
		display:none;
	}
	.homepageslider {
	
	display: none;
}
  .megamenu{
    margin-left: 0 ;
    margin-right: 0 ;
  }
  .megamenu> li {
    margin-bottom: 30px;
  }
  .megamenu> li:last-child {
    margin-bottom: 0;
  }
  .megamenu.dropdown-header {
    padding: 3px 15px !important;
  }
  .navbar-nav .open .dropdown-menu .dropdown-header{
	color:#fff;
  }
}

</style>























<style>
.txtcenter {
	position: absolute;
	left: 42%;
	top: -5px;
}
.header {
	min-height: 80px;
	position: relative;
}
.bottomnavigation {
	background-color: #c9171e;
}
.liststyle a {
	font-size: 16px;
	color: #fff !important;
	padding-left: 20px;
	font-weight: 600;
}
.liststyle {
	width: 100%;
	display: inline-block;
	
}
.bottomnavigation .navbar {
	position: relative;
	min-height: 0px;
	
	border: 1px solid transparent;
	
	margin-bottom: 0px !important;
}
.dropdown-menu > li > a {
	display: block;
	padding: 3px 20px;
	clear: both;
	font-weight: 400;
	line-height: 1.42857143;
	color: #333;
	white-space: nowrap;
	font-size: 17px;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .open > a:hover {
	color: #fff;
	background-color: #e7e7e7;
}
.bottomnavigation .dropdown-menu {
	
	background-color: #fff;
	-webkit-background-clip: padding-box;
	background-clip: padding-box;
	border: 1px solid #ccc;
	border: 1px solid rgba(0,0,0,.15);
	border-radius: 4px;
	-webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
	box-shadow: 0 6px 12px rgba(0,0,0,.175);
}
.liststyle li {
	float: left;
	color: #fff;
}
.navbar-default {
	background-color: #f8f8f8;
	border-color: #e7e7e7;
	border-bottom: 1px solid #e8e8e8;
	min-height: 80px;
}
 
/* makes main-menu open on hover */
.nav-item:hover > .dropdown-menu {
  display: block;
}

/* makes sub-menu S open on hover */
.submenu-item:hover > .dropdown-menu {
  display: block;
}
.liststyle {
    margin-top: 10px !important;
    margin-bottom: 10px;
}
@media screen and (max-width: 768px) {
 .txtcenter {
	
	display: none;
}
.txtcentermobile {
	display: block;
}
}
@media screen and (min-width: 769px) {
 .txtcenter {
	
	display: block;
}
.txtcentermobile {
	display: none;
}
}
</style>
<div class="header">
	<nav class="navbar navbar-site navbar-default" role="navigation">
		<div class="container">
		
			<div class="navbar-header">
			<div class="txtcentermobile">
				{{-- Logo --}}
				<a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
					<img src="{{ \Storage::url(config('settings.app.logo')) . getPictureVersion() }}"
						 alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
						 data-toggle="tooltip"
						 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
				</a>
				</div>
				{{-- Toggle Nav --}}
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				{{-- Country Flag (Mobile) --}}
				@if (getSegment(1) != trans('routes.countries'))
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (!empty(config('country.icode')))
							@if (file_exists(public_path().'/images/flags/24/'.config('country.icode').'.png'))
								<button class="flag-menu country-flag visible-xs btn btn-default hidden" href="#selectCountry" data-toggle="modal">
									<img src="{{ url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;">
									<span class="caret hidden-xs"></span>
								</button>
							@endif
						@endif
					@endif
				@endif
				
				
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					
					
					@if (!auth()->check())
						<li>
							@if (config('settings.security.login_open_in_modal'))
								<a href="#quickLogin" data-toggle="modal"><i class="icon-user fa"></i> {{ t('Log In') }}</a>
							@else
								<a href="{{ lurl(trans('routes.login')) }}"><i class="icon-user fa"></i> {{ t('Log In') }}</a>
							@endif
						</li>
						<li><a href="{{ lurl(trans('routes.register')) }}"><i class="icon-user-add fa"></i> {{ t('Register') }}</a></li>
					@else
						<li>
							@if (app('impersonate')->isImpersonating())
								<a href="{{ route('impersonate.leave') }}">
									<i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
								</a>
							@else
								<a href="{{ lurl(trans('routes.logout')) }}">
									<i class="glyphicon glyphicon-off hidden-sm"></i> {{ t('Log Out') }}
								</a>
							@endif
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-user fa hidden-sm"></i>
								<span>{{ auth()->user()->name }}</span>
								<span class="badge badge-important count-conversations-with-new-messages">0</span>
								<i class="icon-down-open-big fa hidden-sm"></i>
							</a>
							<ul class="dropdown-menu user-menu">
								<li class="active">
									<a href="{{ lurl('account') }}">
										<i class="icon-home"></i> {{ t('Personal Home') }}
									</a>
								</li>
								<li><a href="{{ lurl('account/my-posts') }}"><i class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
								<li><a href="{{ lurl('account/favourite') }}"><i class="icon-heart"></i> {{ t('Favourite ads') }} </a></li>
								<li><a href="{{ lurl('account/saved-search') }}"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
								<li><a href="{{ lurl('account/pending-approval') }}"><i class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
								<li><a href="{{ lurl('account/archived') }}"><i class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
								<li>
									<a href="{{ lurl('account/conversations') }}">
										<i class="icon-mail-1"></i> {{ t('Conversations') }}
										<span class="badge badge-important count-conversations-with-new-messages">0</span>
									</a>
								</li>
								<li><a href="{{ lurl('account/transactions') }}"><i class="icon-money"></i> {{ t('Transactions') }}</a></li>
							</ul>
						</li>
					@endif
					
					@if (config('plugins.currencyexchange.installed'))
						@include('currencyexchange::select-currency')
					@endif
					
					{{-- Country Flag --}}
					@if (getSegment(1) != trans('routes.countries'))
						@if (config('settings.geo_location.country_flag_activation'))
							@if (!empty(config('country.icode')))
								@if (file_exists(public_path().'/images/flags/32/'.config('country.icode').'.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
										@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
											<a href="#selectCountry" data-toggle="modal">
												<img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;">
												<span class="caret hidden-sm"></span>
											</a>
										@else
											<a style="cursor: default;">
												<img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;">
											</a>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endif
					
					
					
					
					
					
					
					
				</ul>
				<div class="txtcenter">
				{{-- Logo --}}
				<a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
					<img src="{{ \Storage::url(config('settings.app.logo')) . getPictureVersion() }}"
						 alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
						 data-toggle="tooltip"
						 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
				</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					
					
					<li class="postadd">
						@if (!auth()->check())
							@if (config('settings.single.guests_can_post_ads') != '1')
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin" data-toggle="modal">
									<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
								</a>
							@else
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ lurl('posts/banneroption') }}">
									<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
								</a>
							@endif
						@else
							<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
								<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
							</a>
							<!-- <a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ lurl('posts/banneroption') }}">
								<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
							</a> -->
						@endif
					</li>
					
					@include('layouts.inc.menu.select-language')
					
				</ul>
			</div>
		</div>
	</nav>
</div>
<?php

$getallcat = HomeController::getmenucategory();
	
?>
<div class="bottomnavigation">
<div class="navbar navbar-default navbar-static-top">
   <div class="container" style="position:relative;">
   
      <div class="navbar-collapse collapse">
	  <ul class="nav navbar-nav">
	  <?php 
	  foreach($getallcat as $parentcate){
	  ?>
	  <li class="dropdown menu-large">
               <a href="/category/<?php echo $parentcate->slug; ?>" class="dropdown-toggle"> 
			   <i class="<?php echo $parentcate->icon_class;  ?>"></i>
			   <?php echo $parentcate->name; ?> </a>
			   <?php 
			    $childcategory = HomeController::getmenuchildallcategory($parentcate->id);
			   ?>
			   <ul class="dropdown-menu megamenu row dropdown-content">
			   <?php foreach($childcategory as $childcat){ 
			  ?>
			     <li class="col-sm-6 col-md-6">
				  <a href="/category/<?php echo $parentcate->slug; ?>/<?php echo $childcat->slug; ?>" class="submenulink">
				  <?php echo $childcat->name; ?>
				  </a>
				   </li>
			   <?php } ?>
			   </ul>
	  </li>
	  <?php } ?>
	  </ul>
        <!-- <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li class="dropdown menu-large">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Products <b class="caret"></b> </a>
               <ul class="dropdown-menu megamenu row">
                  <li>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <a href="#" class="thumbnail">
                        <img src="http://placehold.it/150x120" />
                        </a>
                     </div>
                  </li>
               </ul>
            </li>
            <li class="dropdown menu-large">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <b class="caret"></b></a>          
               <ul class="dropdown-menu megamenu row">
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">Software</li>
                        <li><a href="#">Desktop</a></li>
                        <li class="disabled"><a href="#">Mobile</a></li>
                        <li><a href="#">Tablet</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Hardware</li>
                        <li><a href="#">Arduino</a></li>
                        <li><a href="#">Raspberry PI</a></li>
                        <li><a href="#">VoCore</a></li>
                        <li><a href="#">Banana PI</a></li>
                     </ul>
                  </li>
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">Nano-Tech</li>
                        <li><a href="#">AFM</a></li>
                        <li><a href="#">STM</a></li>
                        <li><a href="#">Nano-Tubes</a></li>
                        <li><a href="#">Nano-Wires</a></li>
                        <li><a href="#">Materials</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">A.I.</li>
                        <li><a href="#">Artificial Intelligence</a></li>
                     </ul>
                  </li>
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">SaaS</li>
                        <li><a href="#">On-Demand</a></li>
                        <li><a href="#">No Software</a></li>
                        <li><a href="#">Cloud Computing</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">On-Premise</li>
                        <li><a href="#">Data Center</a></li>
                        <li><a href="#">Hosting Environment</a></li>
                        <li><a href="#">Internal IT</a></li>
                     </ul>
                  </li>
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">Server-Side</li>
                        <li><a href="#">PHP</a></li>
                        <li><a href="#">Java</a></li>
                        <li><a href="#">Python</a></li>
                        <li><a href="#">Ruby</a></li>
                        <li><a href="#">ColdFusion</a></li>
                        <li><a href="#">ASP.NET</a></li>
                        <li><a href="#">GO</a></li>
                        <li><a href="#">Perl</a></li>
                        <li><a href="#">Lasso</a></li>
                     </ul>
                  </li>
               </ul>
            </li>
            <li class="dropdown menu-large">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services <b class="caret"></b></a>          
               <ul class="dropdown-menu megamenu row">
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">Web Design</li>
                        <li><a href="#">HTML5</a></li>
                        <li class="disabled"><a href="#">CSS</a></li>
                        <li><a href="#">JavaScript</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Web Development</li>
                        <li><a href="#">Websites</a></li>
                        <li><a href="#">Mobile Apps</a></li>
                        <li><a href="#">Responsive</a></li>
                        <li><a href="#">Web Apps</a></li>
                     </ul>
                  </li>
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">Graphic Design</li>
                        <li><a href="#">PSD</a></li>
                        <li><a href="#">Images</a></li>
                        <li><a href="#">Logos</a></li>
                        <li><a href="#"></a></li>
                        <li><a href="#">Vertical variation</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Database Design</li>
                        <li><a href="#">Single button dropdowns</a></li>
                     </ul>
                  </li>
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">UI/UX Design</li>
                        <li><a href="#">User Interface</a></li>
                        <li><a href="#">User Experience</a></li>
                        <li><a href="#">Web Designers</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Digital Marketing</li>
                        <li><a href="#">Paid</a></li>
                        <li><a href="#">Social</a></li>
                        <li><a href="#">Content Marketing</a></li>
                     </ul>
                  </li>
                  <li class="col-sm-3">
                     <ul>
                        <li class="dropdown-header">Project Management</li>
                        <li><a href="#">Initiating</a></li>
                        <li><a href="#">Planning</a></li>
                        <li><a href="#">Executing</a></li>
                        <li><a href="#">Monitoring</a></li>
                        <li><a href="#">Controlling</a></li>
                        <li><a href="#">Closing</a></li>
                        <li><a href="#">PM Systems</a></li>
                        <li><a href="#">Best Practices</a></li>
                        <li><a href="#">Project Manager</a></li>
                     </ul>
                  </li>
               </ul>
            </li>
         </ul> -->
      </div>
   </div>
</div>

</div>


