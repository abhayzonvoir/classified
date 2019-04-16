<div id="stepWizard" class="container">
    <div class="row">
        <div class="col-lg-12">
            <section>
                <div class="wizard">
                    
                    <ul class="nav nav-wizard">
					
                        @if (getSegment(2) == 'addbanner')
                            <?php $uriPath = getSegment(4); ?>
							@if (!in_array($uriPath, ['finish']))
								<li class="{{ ($uriPath == '') ? 'active' : (in_array($uriPath, ['photos', 'packages', 'finish']) or (isset($post) and !empty($post)) ? '' : 'disabled') }}">
									
										<a href="/bottombanner/addbanner/">Add Banner</a>
									
								</li>
							
								<li class="picturesBloc {{ ($uriPath == 'photos') ? 'active' : ((in_array($uriPath, ['photos', 'packages', 'finish']) or (isset($post) and !empty($post))) ? '' : 'disabled') }}">
									<a href="javascript:void(0);">Payment</a>
								</li>
			
								
								<li class="{{ ($uriPath == 'payment') ? 'active' : ((in_array($uriPath, ['finish']) or (isset($post) and !empty($post))) ? '' : 'disabled') }}">
									<a href="javascript:void(0);">Fanish</a>
								</li>
								
                           
                            @else
                            <li class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">
                                <a>{{ t('Finish') }}</a>
                            </li>
                            @endif
                        @else
                            <?php $uriPath = getSegment(3); ?>
						
							@if (!in_array($uriPath, ['finish']))
							
							
							<li class="{{ ($uriPath == 'payment') ? 'active' : '' }}">
									<a href="javascript:void(0);">Banner</a>
								</li>
								@if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
								<li class="{{ ($uriPath == 'payment') ? 'active' : '' }}">
									@if (isset($post) and !empty($post))
										<a href="{{ lurl('posts/' . $post->id . '/payment') }}">{{ t('Payment') }}</a>
									@else
										<a>{{ t('Payment') }}</a>
									@endif
								</li>
								@endif
							@endif
        
                            <li class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">
                                <a>{{ t('Finish') }}</a>
                            </li>
                        @endif
                    </ul>
                    
                </div>
            </section>
        </div>
    </div>
</div>

@section('after_styles')
    @parent
	@if (config('lang.direction') == 'rtl')
    	<link href="{{ url('assets/css/rtl/wizard.css') }}" rel="stylesheet">
	@else
		<link href="{{ url('assets/css/wizard.css') }}" rel="stylesheet">
	@endif
@endsection
@section('after_scripts')
    @parent
@endsection