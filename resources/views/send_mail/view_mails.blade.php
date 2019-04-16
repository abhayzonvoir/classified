@extends('admin::layout')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
    <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
    <section class="content-header">
        <h1>
          All Mails
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admin_url('dashboard') }}">Admin</a></li>
            <li class="active">View all Mail</li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Default box -->

    <div class="box box-primary">
	
		<table class="table">
      <thead>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Content</th>
          
      </thead>   
      <tbody>
        @foreach($m_val as $vr)
          <tr>
              <td>{{$vr->name}}</td>
              <td>{{$vr->email}}</td>
              <td>{{$vr->subj}}</td>
              <td>{!! $vr->description !!}</td>
          </tr>
          @endforeach
      </tbody>   
        </table>
		
        <div class="box-body">
			
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  <!--   <a href="view_email_list">View List</a> -->

@endsection

@section('after_styles')
	@include('layouts.inc.tools.wysiwyg.css')
@endsection

@section('after_scripts')
	<link media="all" rel="stylesheet" type="text/css" href="http://127.0.0.1:8000/assets/plugins/simditor/styles/simditor.css" />
    @include('layouts.inc.tools.wysiwyg.js')
   
    
    
@endsection
