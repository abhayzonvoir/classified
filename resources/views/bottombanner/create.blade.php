{{--
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
--}}
@extends('layouts.master')

<style>
.form-group.baarlin {
	padding: 10px;
}

.container1 {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container1 input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #d1171e;
}

/* On mouse-over, add a grey background color */
.container1:hover input ~ .checkmark {
  background-color: #ccc;
}
.file-drop-zone {
    border: 1px dashed #aaa;
    border-radius: 4px;
    height: 100%;
    text-align: center;
    vertical-align: middle;
    margin: 20px 15px 12px 12px;
    padding: 5px;
}

/* When the checkbox is checked, add a blue background */
.container1 input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container1 input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container1 .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
@section('wizard')
	@include('bottombanner.inc.wizard')
@endsection
@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container" style="margin-bottom: 30px;">
			<div class="row">
			@include('post.inc.notification')
			<div class="col-md-9 page-content">
			<div class="inner-box category-content">
			 <h2 class="title-2"><strong> <i class="icon-docs"></i>Banner</strong></h2>
			<div class="row">
			
                            <div class="col-sm-12">
                                <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
									
                                    <fieldset>
                                       <div class="form-group baarlin">
                                            <!-- Pictures -->
                                            <div id="picturesBloc" class="form-group" style="height:200px;padding: 10px;"> 
											
                                                <label class="col-md-3 control-label" for="pictures"> {{ t('Pictures') }} </label>
                                                
                                                    <div class="file-loading mb10">
                                                        <input id="pictureField" name="pictures" type="file" class="file picimg">
                                                    </div>
                                                   
                                               
                                            </div>
											</div>
											 </fieldset>
									
											 <div class="clearfix" style="clear: both;"></div>
											 
											   <fieldset>
											   <div class="form-group baarlin" style="margin-top: 33px;">
									<!-- <label for="usr">Banner Link:</label>
                                    <input type="text" class="form-control" id="bannerlink" name="bannerlink"/> -->
									</div>
									<div class="form-group baarlin">
									<label for="usr">Select Package:</label>
                                    <select name="package_id" class="form-control">
											 <option value=''>Select Any Package</option>
											 @foreach ($getallpackage as $package)
											<option value='{{$package->tid}}'>{{$package->name}} $ {{ $package->price }}</option>
											@endforeach
											</select>
									</div>
									
									
                                      <!--  <div class="col-md-12">
					                    <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
										<textarea class="form-control {{ $ckeditorClass }}" id="description" name="content" rows="10"></textarea>
					                    <p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
					                </div> -->
                                   </fieldset>
											 
											 
									  
									   
                                        <div class="col-md-12" style="width:100%;text-align:center; margin-bottom:10px;">
                                            <div class="form-group baarlin">
									   <input type="checkbox" name="termscondition" id="termscondition"> I have accepted <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Terms and Conditions</a>
									   </div>
                                          <button id="nextStepBtn" class="btn btn-primary btn-lg" disabled type="submit">Next</button>
										  </div>
                                         
										  </fieldset>
                                        <div style="margin-bottom: 30px;"></div>
                                    
                                    
                                </form>
                            </div>
                        </div>
					
					
					
					
					
					
					
					
					
					
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Post Free Ads') }}</strong></h3>
							<p>
								{{ t('Do you have something to sell, to rent, any service to offer or a job offer? Post it at :app_name, its free, local, easy, reliable and super fast!', ['app_name' => config('app.name')]) }}
							</p>
						</div>

						<div class="panel sidebar-panel">
							<div class="panel-heading uppercase">
								<small><strong>{{ t('How to sell quickly?') }}</strong></small>
							</div>
							<div class="panel-content">
								<div class="panel-body text-left">
									<ul class="list-check">
										<li> {{ t('Use a brief title and description of the item') }} </li>
										<li> {{ t('Make sure you post in the correct category') }}</li>
										<li> {{ t('Add nice photos to your ad') }}</li>
										<li> {{ t('Put a reasonable price') }}</li>
										<li> {{ t('Check the item before publish') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Terms and conditions</h4>
        </div>
        <div class="modal-body">
          <p>
		  <?php 
		  
		  echo $bdraw->content;
		  
		  ?>
		  </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
		
		
		
	</div>
@endsection

@section('after_styles')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
		.file-loading:before {
			content: " {{ t('Loading') }}...";
		}
		.krajee-default.file-preview-frame .kv-file-content {
    width: 100px !important;
    height: 69px !important;
}
.file-drop-zone {
    border: 1px dashed #aaa;
    border-radius: 4px;
    height: 100%;
    text-align: center;
    vertical-align: middle;
    margin: 15px 15px 12px 12px;
    padding: 5px;
}
    </style>
@endsection


@section('after_scripts')
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
        <script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
    @endif
   
    <!-- <link media="all" rel="stylesheet" type="text/css" href="{{ url('assets/plugins/simditor/styles/simditor.css') }}" />
    @include('layouts.inc.tools.wysiwyg.js')
   
     -->
    

   <script>
   $(document).ready(function() {
     $('#termscondition').click(function(){
    if($(this).prop("checked") == true){
  $('#nextStepBtn').prop('disabled', false);
                

     }else {
		 
		 
		 $('#nextStepBtn').prop('disabled', true);
		 
	 }	
		
		
		
	});
   
   });
   </script>
    
@endsection
