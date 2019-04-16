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

@section('wizard')
    @include('bottombanner.inc.wizard')
@endsection

@section('content')
	@include('common.spacer')
    <div class="main-container">
        <div class="container">
            <div class="row">
    
              
                
                <div class="col-md-12 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2"><strong> <i class="icon-tag"></i> {{ t('Pricing') }}</strong></h2>
                        <div class="row">
                            <div class="col-sm-12">
							
							@if ($errors->any())
								<div class="alert alert-danger">
        {{ implode('', $errors->all(':message')) }}
		</div>
@endif
                                <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="post_id" value="{{$id}}">
									
		                             <div class="form-group <?php echo (isset($errors) and $errors->has('package_id')) ? 'has-error' : ''; ?>"
                                                     style="margin-bottom: 0;">
                                     <table id="packagesTable" class="table table-hover checkboxtable" style="margin-bottom: 0;">
									
									 @foreach ($packages as $package)
                                                            <?php
                                                           
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input class="package-selection" type="radio" name="package_id"
                                                                                   id="packageId-{{ $package->tid }}"
                                                                                   value="{{ $package->tid }}"
																				   data-name="{{ $package->name }}"
																				   data-currencysymbol="{{ $package->currency->symbol }}"
																				   data-currencyinleft="{{ $package->currency->in_left }}"
                                                                                   >
                                                                            <strong class="tooltipHere" title="" data-placement="right" data-toggle="tooltip" data-original-title="{!! $package->description !!}">{!! $package->name!!} </strong>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p id="price-{{ $package->tid }}">
                                                                        @if ($package->currency->in_left == 1)
                                                                            <span class="price-currency">{!! $package->currency->symbol !!}</span>
                                                                        @endif
                                                                        <span class="price-int">{{ $package->price }}</span>
                                                                        @if ($package->currency->in_left == 0)
                                                                            <span class="price-currency">{!! $package->currency->symbol !!}</span>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
													</table>
                                                  </div>
                                           @if (isset($paymentMethods) and $paymentMethods->count() > 0)
                                                <!-- Payment Plugins -->
                                                <?php $hasCcBox = 0; ?>
                                                @foreach($paymentMethods as $paymentMethod)
                                                    @if (view()->exists('payment::' . $paymentMethod->name))
                                                        @include('payment::' . $paymentMethod->name, [$paymentMethod->name . 'PaymentMethod' => $paymentMethod])
                                                    @endif
                                                    <?php if ($paymentMethod->has_ccbox == 1 && $hasCcBox == 0) $hasCcBox = 1; ?>
                                                @endforeach
                                            @endif
                                       <!-- Button  -->
                                        <div class="form-group">
                                            <div class="col-md-12 mt20" style="text-align: center;">
                                               
												
                                                <button id="submitPostForm" class="btn btn-success btn-lg submitPostForm" type="submit"> {{ t('Pay') }} </button>
                                            </div>
                                        </div>
                                        
                                        <div style="margin-bottom: 30px;"></div>                                     
									 
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
        <script src="{{ url('/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
    @endif
<script>

			
			
			$(document).ready(function ()
			{
				/* Show price & Payment Methods */
				var selectedPackage = $('input[name=package_id]:checked').val();
				var packagePrice = getPackagePrice(selectedPackage);
				var packageCurrencySymbol = $('input[name=package_id]:checked').data('currencysymbol');
				var packageCurrencyInLeft = $('input[name=package_id]:checked').data('currencyinleft');
				var paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
				showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
				showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
				
				/* Select a Package */
				$('.package-selection').click(function () {
					selectedPackage = $(this).val();
					packagePrice = getPackagePrice(selectedPackage);
					packageCurrencySymbol = $(this).data('currencysymbol');
					packageCurrencyInLeft = $(this).data('currencyinleft');
					showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
					showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
				});
				
				/* Select a Payment Method */
				$('#paymentMethodId').on('change', function () {
					paymentMethod = $(this).find('option:selected').data('name');
					showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
				});
				
				/* Form Default Submission */
				$('#submitPostForm').on('click', function (e) {
					e.preventDefault();
					
					if (packagePrice <= 0) {
						$('#postForm').submit();
					}
					
					return false;
				});
			});
        
       
		/* Show or Hide the Payment Submit Button */
		/* NOTE: Prevent Package's Downgrading */
		/* Hide the 'Skip' button if Package price > 0 */
		function showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod)
		{
			if (packagePrice > 0) {
				$('#submitPostForm').show();
				$('#skipBtn').hide();
				
				if (currentPackagePrice > packagePrice) {
					$('#submitPostForm').hide();
				}
				if (currentPackagePrice == packagePrice) {
					if (paymentMethod == 'offlinepayment' && currentPaymentActive != 1) {
						$('#submitPostForm').hide();
						$('#skipBtn').show();
					}
				}
			} else {
				$('#skipBtn').show();
			}
		}


</script>
   
@endsection
