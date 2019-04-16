@extends('admin::layout')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
    <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
    <section class="content-header">
        <h1>
           {{ $title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admin_url('dashboard') }}">Admin</a></li>
            <li class="active">{{ $title }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Default box -->
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <div class="box box-primary">
	
		
		
        <div class="box-body">
			<form  class="form-horizontal" id="mailForm" method="POST" action="sub_mail" enctype="multipart/form-data">
									{!! csrf_field() !!}


									<div class="row">
                                  <div class="col-md-1">
									<label class=" control-label" for="description">Users </label>
                                    </div>
                                    <div class="col-md-11">
									<select class="form-control" style="" multiple="" name="usr[]">
										<option value="">Select Users</option>
										@foreach($user_data as $row)
										<option value="{{$row->id}}">{{$row->name}}</option>
										@endforeach
									</select>
									</div>
                                    </div>



<br>

                                    <div class="row">
                                  <div class="col-md-1">
									<label class="control-label" for="description">Subject </label>
								</div>
								 <div class="col-md-11">
									<input type="text" name="subj" class="form-control" >
								</div>
							</div>
                            <br>
									
            <div class="form-group required <?php echo (isset($errors) and $errors->has('description')) ? 'has-error' : ''; ?>">
            	<div class="row">
                                  <div class="col-md-1">
				<label class="col-md-3 control-label" for="description">{{ t('Description') }} </label>
				</div>
                <div class="col-md-11" style="position: relative; float: right; padding-top: 10px;">
                    <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
					<textarea class="form-control {{ $ckeditorClass }}" id="description" name="description" rows="10"></textarea>
                    <p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
                </div>
            </div>
			</div>
			<input type="submit" name="submit" value="Submit" class="btn btn-primary">
        	</form>
        </div><!-- /.box-body -->
         <a href="view_email_list" style="margin-left: 1007px;
    margin-top: -41px;font-size: 18px;">View List</a>
    </div><!-- /.box -->
   

@endsection

@section('after_styles')
	@include('layouts.inc.tools.wysiwyg.css')
@endsection

@section('after_scripts')
	<link media="all" rel="stylesheet" type="text/css" href="{{ url('assets/plugins/simditor/styles/simditor.css') }}" />
    @include('layouts.inc.tools.wysiwyg.js')
   
    
    
@endsection
