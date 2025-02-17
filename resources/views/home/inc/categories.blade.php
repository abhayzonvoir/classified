@if (isset($categoriesOptions) and isset($categoriesOptions['type_of_display']))
	
	<div class="container">
		<div class="col-lg-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<div class="col-lg-12 box-title no-border">
					<div class="inner">
						<h2>
							<span class="title-3">{{ t('Browse by') }} <span style="font-weight: bold;">{{ t('Category') }}</span></span>
							<?php $attr = ['countryCode' => config('country.icode')]; ?>
							<a href="{{ lurl(trans('routes.v-sitemap', $attr), $attr) }}" class="sell-your-item">
								{{ t('View more') }} <i class="icon-th-list"></i>
							</a>
						</h2>
					</div>
				</div>
				
				@if ($categoriesOptions['type_of_display'] == 'c_picture_icon')
					
					@if (isset($categories) and $categories->count() > 0)
						@foreach($categories as $key => $cat)
							<div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 f-category">
								<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; ?>
								<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
									<img src="{{ \Storage::url($cat->picture) . getPictureVersion() }}" class="img-responsive" alt="img">
									<h6> {{ $cat->name }} </h6>
								</a>
							</div>
						@endforeach
					@endif
					
				@elseif (in_array($categoriesOptions['type_of_display'], ['cc_normal_list', 'cc_normal_list_s']))
					
					<div style="clear: both;"></div>
					<?php $styled = ($categoriesOptions['type_of_display'] == 'cc_normal_list_s') ? ' styled' : ''; ?>
					
					@if (isset($categories) and $categories->count() > 0)
						<div class="list-categories-children{{ $styled }}">
							@foreach ($categories as $key => $cols)
								<div class="col-md-4 col-sm-4 {{ (count($categories) == $key+1) ? 'last-column' : '' }}">
									@foreach ($cols as $iCat)
										
										<?php
											$randomId = '-' . substr(uniqid(rand(), true), 5, 5);
										?>
									
										<div class="cat-list">
											<h3 class="cat-title rounded">
												@if (isset($categoriesOptions['show_icon']) and $categoriesOptions['show_icon'] == 1)
													<i class="{{ $iCat->icon_class or 'icon-ok' }}"></i>&nbsp;
												@endif
												<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $iCat->slug]; ?>
												<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
													{{ $iCat->name }} <span class="count"></span>
												</a>
												<span data-target=".cat-id-{{ $iCat->id . $randomId }}" data-toggle="collapse" class="btn-cat-collapsed collapsed">
													<span class="icon-down-open-big"></span>
												</span>
											</h3>
											<ul class="cat-collapse collapse in cat-id-{{ $iCat->id . $randomId }} long-list-home">
												@if (isset($subCategories) and $subCategories->has($iCat->tid))
													@foreach ($subCategories->get($iCat->tid) as $iSubCat)
														<li>
															<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $iCat->slug, 'subCatSlug' => $iSubCat->slug]; ?>
															<a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}">
																{{ $iSubCat->name }}
															</a>
														</li>
													@endforeach
												@endif
											</ul>
										</div>
									@endforeach
								</div>
							@endforeach
							<div style="clear: both;"></div>
						</div>
					@endif
					
				@else
					
					<?php
					$listTab = [
						'c_circle_list' => 'list-circle',
						'c_check_list'  => 'list-check',
						'c_border_list' => 'list-border',
					];
					$catListClass = (isset($listTab[$categoriesOptions['type_of_display']])) ? 'list ' . $listTab[$categoriesOptions['type_of_display']] : 'list';
					?>
					@if (isset($categories) and $categories->count() > 0)
						<div class="list-categories">
							@foreach ($categories as $key => $items)
								<ul class="cat-list {{ $catListClass }} col-xs-4 {{ (count($categories) == $key+1) ? 'cat-list-border' : '' }}">
									@foreach ($items as $k => $cat)
										<li>
											@if (isset($categoriesOptions['show_icon']) and $categoriesOptions['show_icon'] == 1)
												<i class="{{ $cat->icon_class or 'icon-ok' }}"></i>&nbsp;
											@endif
											<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; ?>
											<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
												{{ $cat->name }}
											</a>
										</li>
									@endforeach
								</ul>
							@endforeach
						</div>
					@endif
					
				@endif
		
			</div>
		</div>
	</div>
@endif

@section('before_scripts')
	@parent
	@if (isset($categoriesOptions) and isset($categoriesOptions['max_sub_cats']) and $categoriesOptions['max_sub_cats'] >= 0)
		<script>
			var maxSubCats = {{ (int)$categoriesOptions['max_sub_cats'] }};
		</script>
	@endif
@endsection
