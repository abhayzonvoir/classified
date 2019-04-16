<?php
// Init.
$sForm = [
	'enableFormAreaCustomization' => '0',
	'hideTitles'                  => '0',
	'title'                       => t('Sell and buy near you'),
	'subTitle'                    => t('Simple, fast and efficient'),
	'bigTitleColor'               => '', // 'color: #FFF;',
	'subTitleColor'               => '', // 'color: #FFF;',
	'backgroundColor'             => '', // 'background-color: #444;',
	'backgroundImage'             => '', // null,
	'height'                      => '', // '450px',
	'parallax'                    => '0',
	'hideForm'                    => '0',
	'formBorderColor'             => '', // 'background-color: #333;',
	'formBorderSize'              => '', // '5px',
	'formBtnBackgroundColor'      => '', // 'background-color: #4682B4; border-color: #4682B4;',
	'formBtnTextColor'            => '', // 'color: #FFF;',
];

// Get Search Form Options
if (isset($searchFormOptions)) {
	if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
		$sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
	}
	if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
		$sForm['hideTitles'] = $searchFormOptions['hide_titles'];
	}
	if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
		$sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
		$sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
		if (str_contains($sForm['title'], '{count_ads}')) {
			try {
				$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
			} catch (\Exception $e) {
				$countPosts = 0;
			}
			$sForm['title'] = str_replace('{count_ads}', $countPosts, $sForm['title']);
		}
		if (str_contains($sForm['title'], '{count_users}')) {
			try {
				$countUsers = \App\Models\User::count();
			} catch (\Exception $e) {
				$countUsers = 0;
			}
			$sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
		}
	}
	if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
		$sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
		$sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
		if (str_contains($sForm['subTitle'], '{count_ads}')) {
			try {
				$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
			} catch (\Exception $e) {
				$countPosts = 0;
			}
			$sForm['subTitle'] = str_replace('{count_ads}', $countPosts, $sForm['subTitle']);
		}
		if (str_contains($sForm['subTitle'], '{count_users}')) {
			try {
				$countUsers = \App\Models\User::count();
			} catch (\Exception $e) {
				$countUsers = 0;
			}
			$sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
		}
	}
	if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
		$sForm['parallax'] = $searchFormOptions['parallax'];
	}
	if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
		$sForm['hideForm'] = $searchFormOptions['hide_form'];
	}
}

// Country Map status (shown/hidden)
$showMap = false;
if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
	if (isset($citiesOptions) and isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
		$showMap = true;
	}
}
?>
<style>
.formactive {
	background-color: #000;
}
.titles {
	margin-top: 5px;
}
.navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > li > a:hover {
	color: #000;
}

.searchcontainercat {
    background: rgba(0,0,0,.6);
    width: 720px;
    margin-top: 30px;
    position: absolute;
    left:18%;
    z-index: 100;
    border-radius: 2px;
}
.searchcontainercatinner {
color: #fff;
border-bottom: 1px solid rgba(255,255,255,.2);
display: -webkit-box;
display: -webkit-flex;
display: -ms-flexbox;
display: flex;
}
.mySearchboxsquare:first-child {
	width: 120px;
}

.mySearchboxsquare {
	width: 100px;
	height: 75px;
	text-align: center;
	padding: 16px 12px 12px;
	box-sizing: border-box;
	line-height: 12px;
	cursor: pointer;
	font-size: 12px;
	font-weight: 700;
	float: left;
}
.mySearchboxsquare.searchoxcat.searchactive {
	background-color: #000;
}
.categoryicons {
	font-size: 22px;
}
.Searchbox__bottom {
	padding: 12px;
}
.Searchbox__keyword__input {
	width: 558px;
	margin-right: 4px;
	padding: 12px;
}
.Searchbox__search__button {
	background: #d8171e;
	padding: 12px 38px;
	border: none;
	color: #fff;
	font-size: 15px;
	border-radius: 2px;
	cursor: pointer;
	font-weight: 700;
	width: 124px;
}
.mySearchboxsquare:not(:last-child), .lang-ar .mySearchboxsquare:last-child, .lang-ar .mySearchboxsquare:not(:first-child) {
	border-right: 1px solid rgba(255,255,255,.2);
}
.searchtitle {
	color: #fff;
	margin: 0;
	font-size: 28px;
	padding-top: 70px;
	text-shadow: 0 0 2px rgba(0,0,0,.5);
}
.searchtitle, .Searchbox__bottom, .Searchbox__category__icon, .Trending__block {
	text-align: center;
	font-weight: bolder;
}
.col-md-6.pddingleft {
	margin-top: 10px;
	margin-right: 0px;
	padding-left: 29px;
}
.col-md-6.pddingright {
	margin-top: 10px;
	margin-right: 0px;
	padding-left: 29px;
}
.searchcategory{
	display:none;
	
}
.wide-intro.parallax {
	display: none;
}
</style>
<?php 


if(!empty($slider)){
?>
<style>
.homepageslider{
 background: rgba(0, 0, 0, 0) url("/storage/<?php echo $slider->slider; ?>") repeat scroll 0% 0%;
padding-bottom: 48px;
min-height: 350px;
position: relative;
background-size: cover;
 }
</style>
<?php }else {
?>
<style>
.homepageslider{
 background: rgba(0, 0, 0, 0) url("/images/search-background-image-10.jpg") repeat scroll 0% 0%;
padding-bottom: 48px;
min-height: 350px;
position: relative;
background-size: cover;
 }
</style>
<?php } ?>
<div class="container">
<div class="homepageslider">
<div class="searchcontainer">
<h1 class="searchtitle">
        
           Free ads online | Local classifieds | Best place for buyer, seller & Job seekers 
        
    </h1>
<div class="searchcontainercat">
<div class="searchcontainercatinner">

<?php 
$count=1;
foreach($categories as $key => $cols){
	
foreach ($cols as $iCat){
	if($count<8){
		
?>

<div class="mySearchboxsquare searchoxcat" categoryid="<?php echo $iCat->id;  ?>">
<div class="motorvechicals">
<div class="categoryicons">
<i class="<?php echo $iCat->icon_class;  ?>"></i>
</div>
<div class="titles"><?php echo $iCat->name;  ?> </div>
</div>
</div>
<?php 
	}
$count++;
}
} ?>

 


</div>
<form id="seach" name="search" class="formc" action="/search" method="GET">
<div class="row searchcategory">
<div class="col-md-6 pddingleft">
<select name="c"  class="form-control mycategory" style="display:none;">
<option value="">Select Your Category</option>
<?php
foreach($categories as $key => $cols){
	
foreach ($cols as $iCat){ ?>

<option value="<?php echo $iCat->id;  ?>"><?php echo $iCat->name;  ?></option>
<?php 
}
} ?>
</select>
<select name="subcategory" id="subcategory" class="form-control">
<option value="">Select Your sub Category</option>

</select>

</div>
<div class="col-md-6 pddingright">
<input type="text" class="form-control" name="location" placeholder="Enter Your Location" style="width:95%;">

</div>
<!-- <div class="col-md-6 pddingleft">
<input type="text" class="form-control" name="location" placeholder="Enter Your Location">
</div> -->
</div>
<div class="Searchbox__bottom">
            <input type="text" class="Searchbox__keyword__input" name="q" placeholder="Enter keywords">
            <input type="submit" class="Searchbox__search__button" value="Search">
        </div>
		</form>
</div>
</div>
</div>
</div>



@if (isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1')
	
	@if (isset($firstSection) and !$firstSection)
		<div class="h-spacer"></div>
	@endif
	
	<?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
	<div class="wide-intro {{ $parallax }}">
		<div class="dtable hw100">
			<div class="dtable-cell hw100">
				<div class="container text-center">
					
					@if ($sForm['hideTitles'] != '1')
						<h1 class="intro-title animated fadeInDown"> {{ $sForm['title'] }} </h1>
						<p class="sub animateme fittext3 animated fadeIn">
							{!! $sForm['subTitle'] !!}
						</p>
					@endif
					
					@if ($sForm['hideForm'] != '1')
						<div class="row search-row fadeInUp">
							<?php $attr = ['countryCode' => config('country.icode')]; ?>
							<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
								<div class="col-lg-5 col-sm-5 search-col relative">
									<i class="icon-docs icon-append"></i>
									<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
								</div>
								<div class="col-lg-5 col-sm-5 search-col relative locationicon">
									<i class="icon-location-2 icon-append"></i>
									<input type="hidden" id="lSearch" name="l" value="">
									@if ($showMap)
										<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
											   placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom"
											   data-toggle="tooltip" type="button"
											   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
									@else
										<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon"
											   placeholder="{{ t('Where?') }}" value="">
									@endif
								</div>
								<div class="col-lg-2 col-sm-2 search-col">
									<button class="btn btn-primary btn-search btn-block">
										<i class="icon-search"></i> <strong>{{ t('Find') }}</strong>
									</button>
								</div>
								{!! csrf_field() !!}
							</form>
						</div>
					@endif
				
				</div>
			</div>
		</div>
	</div>
	
@else
	
	@include('home.inc.spacer')
	<div class="container">
		<div class="intro">
			<div class="dtable hw100">
				<div class="dtable-cell hw100">
					<div class="container text-center">
						<div class="row search-row fadeInUp">
							<?php $attr = ['countryCode' => config('country.icode')]; ?>
							<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 search-col relative">
									<i class="icon-docs icon-append"></i>
									<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
								</div>
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 search-col relative locationicon">
									<i class="icon-location-2 icon-append"></i>
									<input type="hidden" id="lSearch" name="l" value="">
									@if ($showMap)
										<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
											   placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom"
											   data-toggle="tooltip" type="button"
											   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
									@else
										<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon"
											   placeholder="{{ t('Where?') }}" value="">
									@endif
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 search-col">
									<button class="btn btn-primary btn-search btn-block">
										<i class="icon-search"></i> <strong>{{ t('Find') }}</strong>
									</button>
								</div>
								{!! csrf_field() !!}
							</form>
						</div>
	
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
