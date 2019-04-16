<?php
use \App\Http\Controllers\admin\MenuController;
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

.bottomnavigation .dropdown-menu {
	
	background-color: #c9171e;
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
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
									<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
								</a>
							@endif
						@else
							<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
								<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
							</a>
						@endif
					</li>
					
					@include('layouts.inc.menu.select-language')
					
				</ul>
			</div>
		</div>
	</nav>
</div>
<?php
$getallmenus = MenuController::getallmenu(); 

if(isset($getallmenus)){
if(!empty($getallmenus)){	

?>
<div class="bottomnavigation">
<div class="container">


 <nav class="navbar navbar-expand-lg navbar-light bg-light">
 


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto liststyle">
	<?php 
	$mynavigation = json_decode($getallmenus->menupages);
	
	
    foreach($mynavigation as $nav){
	if(isset($nav->children)){
	$dropdownclass = 'dropdown-toggle';
	}else {
		$dropdownclass = '';
	}	
	
		?>
           <li class="nav-item <?php echo $dropdownclass;  ?>">
        <a class="nav-link" href="<?php echo $nav->url; ?>"><?php echo $nav->title; ?></a>
		<?php if(isset($nav->children)){ ?>
		 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		 <?php  $childern = $nav->children; 
			 foreach($childern as $child){ ?>
          <a class="dropdown-item" href="<?php echo $child->url; ?>"><?php echo $child->title; ?></a>
			 <?php } ?>
        </div>
		<?php } ?>
      </li>		
			  <?php } ?>
      <!-- <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
   
  </div>
</nav>











</div>
</div>

<?php 
}
}
?>

