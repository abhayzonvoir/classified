<?php
// Keywords
$countries_name = DB::table('countries')->select('code', 'id','name')->get();
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = request()->get('r');
} else {
	$qLocationId = request()->get('l');
	$qLocation = (request()->filled('r')) ? t('area:') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
	
}
if(!empty($banner)){?>
	<style>
	
	.search-row-wrapper {
		background:url(<?php echo 'https://classifiedzoo.com/storage/'.$banner; ?>);
	height: 350px;
 margin-top: 0px;
padding-top: 170px;
background-size: cover !important;
	}
</style>
	
	<?php 
}

?>
<div class="container">

	<div class="search-row-wrapper">
	
		<div class="container">
			<?php $attr = ['countryCode' => config('country.icode')]; ?>
			<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<input name="q" class="form-control keyword" type="text" placeholder="{{ t('What?') }}" value="{{ $keywords }}">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<select name="c" id="catSearch" class="form-control selecter">
						<option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
						@if (isset($cats) and $cats->count() > 0)
							@foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
								<option {{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 search-col locationicon">
					<i class="icon-location-2 icon-append"></i>
					<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
						   placeholder="{{ t('Where?') }}" value="{{ $qLocation }}" title="" data-placement="bottom"
						   data-toggle="tooltip" type="button"
						   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
				</div>

				<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
				<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
				<!-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<select name="cnt" id="cnt_type" class="form-control selecter">
					<option value="">Select Country</option>
					@foreach($countries_name as $row)
					<option value="{{$row->code}}">{{$row->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<select name="city2" id="city_id" class="form-control selecter">
					<option value="">Select City</option>
					
				</select>
			</div> -->
                  
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<button class="btn btn-block btn-primary">
						<i class="fa fa-search"></i> <strong>{{ t('Find') }}</strong>
					</button>
				</div>
				{!! csrf_field() !!}
			</form>
		</div>
	</div>
	<!-- /.search-row  width: 24.6%; -->
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
$("#cnt_type").change(function()
{
	//alert("hoo");
var code=$(this).val();
console.log(code);

$.ajax
({
type: "GET",
url: "{{url('ajax/category/find_city')}}",
data: {'code':code},
cache: false,
success: function(data)
{
  console.log(data); // I get error and success function does not execute
  data =JSON.parse(data);
  $("#city_id").html(data);
} 
});

});

});
</script>