<?php
/**
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
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use Larapen\Admin\app\Http\Controllers\PanelController;

use App\Http\Requests\Admin\BottombannerRequest as StoreRequest;
use App\Http\Requests\Admin\BottombannerRequest as UpdateRequest;

class BottombannerController extends PanelController
{
	use VerificationTrait;
	
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\bottombanner');
		
		$this->xPanel->setRoute(admin_uri('bannerads'));
		$this->xPanel->setEntityNameStrings(trans('admin::messages.ad'), trans('admin::messages.ads'));
		//$this->xPanel->denyAccess(['create']);
		if (!request()->input('order')) {
			if (config('settings.single.posts_review_activation')) {
				$this->xPanel->orderBy('reviewed', 'ASC');
			}
			$this->xPanel->orderBy('created_at', 'DESC');
		}
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		
		// Hard Filters
		if (request()->filled('active')) {
			if (request()->get('active') == 0) {
				$this->xPanel->addClause('where', 'verified_email', '=', 0);
				$this->xPanel->addClause('orWhere', 'verified_phone', '=', 0);
				if (config('settings.single.posts_review_activation')) {
					$this->xPanel->addClause('orWhere', 'reviewed', '=', 0);
				}
			}
			if (request()->get('active') == 1) {
				$this->xPanel->addClause('where', 'verified_email', '=', 1);
				$this->xPanel->addClause('where', 'verified_phone', '=', 1);
				if (config('settings.single.posts_review_activation')) {
					$this->xPanel->addClause('where', 'reviewed', '=', 1);
				}
			}
		}
		
		
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => '',
			'type'  => 'checkbox',
			'orderable' => false,
		]);
		
	  $this->xPanel->addColumn([
			'name'  => 'created_at',
			'label' => trans("admin::messages.Date"),
			'type'  => 'datetime',
		]);
		$this->xPanel->addColumn([
			'name'  => 'bannerlink',
			'label' => "Banner Link",
			'type'  => 'text',
		]);
		$this->xPanel->addColumn([
			'name'  => 'bannername',
			'label' => "Banner Name",
			'type' => 'model_function',
			'function_name' => 'getbannerHtml',
		]);
		$this->xPanel->addColumn([
			'name'  => 'country',
			'label' => "Country",
	         'type' => 'model_function',
			'function_name' => 'getCountryHtml',
			
		]);
		$this->xPanel->addColumn([
			'name'  => 'amount',
			'label' => "amount",
	         'type' => 'text',
			
			
		]);

		
		$this->xPanel->addColumn([
			'name'  => 'country',
			'label' => "Country",
	         'type' => 'model_function',
			'function_name' => 'getCountryHtml',
			
		]);
		$this->xPanel->addColumn([
			'name'  => 'payment',
			'label' => "payment Status",
	        'type' => 'model_function',
			'function_name' => 'paymentstatus',
			
			
		]);
		$this->xPanel->addColumn([
			'name'  => 'Banner Status',
			'label' => "status",
	        'type' => 'model_function',
			'function_name' => 'bannerstatus',
			
			
		]);
		$this->xPanel->addColumn([
			'name'  => 'paymenttransation',
			'label' => "paymenttransation",
	         'type' => 'text'
			
			
		]);
		
		

		$this->xPanel->addField([
			'label'       => 'Banner Link',
			'name'        => 'bannerlink',
			'type'        => 'text'
			
			
		]);
		
		$this->xPanel->addField([
			'name'   => 'bannername',
			'label'  =>  'Bannername Name',
			'type'   => 'image',
			
			'disk'   => 'public',
			
		]);
		
		$this->xPanel->addField([
			'label'       =>'Payment Status',
			'name'        => 'payment',
			'type'        => 'select2_from_array',
			'options'     => $this->payments(),
			'allows_null' => false,
		]);
		$this->xPanel->addField([
			'label'             => 'country',
			'name'              => 'country',
			'type'              => 'select2_from_array',
			'options'           => getCountries(),
			'allows_null'       => true,
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'label'       =>'Status',
			'name'        => 'status',
			'type'        => 'select2_from_array',
			'options'     => $this->status(),
			'allows_null' => false,
		]);
		
		
		
		// FIELDS
		/* $this->xPanel->addField([
			'label'       => trans("admin::messages.Category"),
			'name'        => 'category_id',
			'type'        => 'select2_from_array',
			'options'     => $this->categories(),
			'allows_null' => false,
		]);
		$this->xPanel->addField([
			'name'       => 'title',
			'label'      => trans("admin::messages.Title"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Title"),
			],
		]);
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => trans("admin::messages.Description"),
			'type'       => (config('settings.single.simditor_wysiwyg'))
				? 'simditor'
				: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'attributes' => [
				'placeholder' => trans("admin::messages.Description"),
				'id'          => 'description',
				'rows'        => 10,
			],
		]);
		$this->xPanel->addField([
			'name'              => 'price',
			'label'             => trans("admin::messages.Price"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin::messages.Enter a Price (or Salary)'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'negotiable',
			'label'             => trans("admin::messages.Negotiable Price"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'label'     => trans("admin::messages.Pictures"),
			'name'      => 'pictures', // Entity method
			'entity'    => 'pictures', // Entity method
			'attribute' => 'filename',
			'type'      => 'read_images',
			'disk'      => 'public',
		]);
		$this->xPanel->addField([
			'name'              => 'contact_name',
			'label'             => trans("admin::messages.User Name"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans("admin::messages.User Name"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'email',
			'label'             => trans("admin::messages.User Email"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans("admin::messages.User Email"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'phone',
			'label'             => trans("admin::messages.User Phone"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin::messages.User Phone'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'phone_hidden',
			'label'             => trans("admin::messages.Hide seller phone"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'label'             => trans("admin::messages.Post Type"),
			'name'              => 'post_type_id',
			'type'              => 'select2_from_array',
			'options'           => $this->postType(),
			'allows_null'       => false,
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'tags',
			'label'             => trans("admin::messages.Tags"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans("admin::messages.Tags"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'verified_email',
			'label'             => trans("admin::messages.Verified Email"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'verified_phone',
			'label'             => trans("admin::messages.Verified Phone"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		if (config('settings.single.posts_review_activation')) {
			$this->xPanel->addField([
				'name'              => 'reviewed',
				'label'             => trans("admin::messages.Reviewed"),
				'type'              => 'checkbox',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
					'style' => 'margin-top: 20px;',
				],
			]);
		}
		$this->xPanel->addField([
			'name'              => 'archived',
			'label'             => trans("admin::messages.Archived"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$entity = $this->xPanel->getModel()->find(request()->segment(3));
		if (!empty($entity)) {
			$this->xPanel->addField([
				'name'  => 'ip_addr',
				'type'  => 'custom_html',
				'value' => '<h5><strong>IP:</strong> ' . $entity->ip_addr . '</h5>',
			], 'update');
		} */
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		
		return parent::updateCrud();
	}
	
	public function postType()
	{
		$entries = PostType::trans()->get();
		
		return $this->getTranslatedArray($entries);
	}
	
	public function payments()
	{
		$tab['C']='Cancel';
		$tab['P']='Pending';
		$tab['S']='Success';
		
		return $tab;
	}
	public function status()
	{
		$tab['A']='Active';
		$tab['P']='Pending';
		
		
		return $tab;
	}
}
