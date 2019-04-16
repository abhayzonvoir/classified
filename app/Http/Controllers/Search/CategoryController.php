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

namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Models\Category;
use App\Models\CategoryField;
use Torann\LaravelMetaTags\Facades\MetaTag;

class CategoryController extends BaseController
{
	public $isCatSearch = true;

    protected $cat = null;
    protected $subCat = null;

    /**
     * @param $countryCode
     * @param $catSlug
     * @param null $subCatSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index($countryCode, $catSlug, $subCatSlug = null)
    {
		
        // Check multi-countries site parameters
        if (!config('settings.seo.multi_countries_urls')) {
            $subCatSlug = $catSlug;
            $catSlug = $countryCode;
        }

        view()->share('isCatSearch', $this->isCatSearch);
         
        // Get Category
        $this->cat = Category::trans()->where('slug', '=', $catSlug)->firstOrFail();
		
        view()->share('cat', $this->cat);

        // Get common Data
        $catName = $this->cat->name;
        $catDescription = $this->cat->description;
		$mycatDescription = $this->cat->description;
	    $banner = $this->cat->banner;
		// Get Category nested IDs
		$catNestedIds = (object)[
			'parentId' => $this->cat->parent_id,
			'id'       => $this->cat->tid,
		];

        // Check if this is SubCategory Request
        if (!empty($subCatSlug))
        {
            $this->isSubCatSearch = true;
            view()->share('isSubCatSearch', $this->isSubCatSearch);

            // Get SubCategory
            $this->subCat = Category::trans()->where('parent_id', $this->cat->tid)->where('slug', '=', $subCatSlug)->firstOrFail();
            view()->share('subCat', $this->subCat);

            // Get common Data
            $catName = $this->subCat->name;
            $catDescription = $this->subCat->description;
            
            // Get Category nested IDs
			$catNestedIds = (object)[
				'parentId' => $this->subCat->parent_id,
				'id'       => $this->subCat->tid,
			];
        }
	
		// Get Custom Fields
		$customFields = CategoryField::getFields($catNestedIds);
		view()->share('customFields', $customFields);

        // Search
        $search = new Search();
        if (isset($this->subCat) && !empty($this->subCat)) {
            $data = $search->setCategory($this->cat->tid, $this->subCat->tid)->setRequestFilters()->fetch();
        } else {
            $data = $search->setCategory($this->cat->tid)->setRequestFilters()->fetch();
        }

        // Get Titles
        $bcTab = $this->getBreadcrumb();
        $htmlTitle = $this->getHtmlTitle();
        view()->share('bcTab', $bcTab);
        view()->share('htmlTitle', $htmlTitle);

        // SEO
        $title = $this->getTitle1();
        if (isset($catDescription) && !empty($catDescription)) {
             $city = getCurrentCity();
             $country = getCurrentCountry();
             $out = str_replace(['{country}' , '{city}'], [ $country , $city], $catDescription);
            // dd($out);
            $description = str_limit($catDescription, 200);
        } else {
            $description = str_limit(t('Free ads :category in :location', [
                    'category' => $catName,
                    'location' => config('country.name')
                ]) . '. ' . t('Looking for a product or service') . ' - ' . config('country.name'), 200);
        }

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);

        // Open Graph
        $this->og->title($title)->description($description)->type('website');
        if ($data['count']->get('all') > 0) {
            if ($this->og->has('image')) {
                $this->og->forget('image')->forget('image:width')->forget('image:height');
            }
        }
        view()->share('og', $this->og);

        // Translation vars
        view()->share('uriPathCatSlug', $catSlug);
        if (!empty($subCatSlug)) {
            view()->share('uriPathSubCatSlug', $subCatSlug);
        }
        $data['banner']=$banner;
        return view('search.serp', $data)->with('catDescription',$mycatDescription);
    }
    public function getTitle1()
    {
        $title = '';
        
        // Init.
        $title .= t('Free ads');
        
        // Keyword
        if (request()->filled('q')) {
            $title .= ' ' . t('for') . ' ';
            $title .= '"' . rawurldecode(request()->get('q')) . '"';
        }
        
        // Category
        if (isset($this->isCatSearch) && $this->isCatSearch) {
            if (isset($this->cat) && !empty($this->cat)) {
                // SubCategory
                if (isset($this->isSubCatSearch) && $this->isSubCatSearch) {
                    if (isset($this->subCat) && !empty($this->subCat)) {
                        $title .= ' ' . $this->subCat->name . ',';
                    }
                }
                
                $title .= ' ' . $this->cat->name;
            }
        }
        
        // User
        if (isset($this->isUserSearch) && $this->isUserSearch) {
            if (isset($this->sUser) && !empty($this->sUser)) {
                $title .= ' ' . t('of') . ' ';
                $title .= $this->sUser->name;
            }
        }
        
        // Tag
        if (isset($this->isTagSearch) && $this->isTagSearch) {
            if (isset($this->tag) && !empty($this->tag)) {
                $title .= ' ' . t('for') . ' ';
                $title .= $this->tag . ' (' . t('Tag') . ')';
            }
        }
        
        // Location
        if ((isset($this->isCitySearch) && $this->isCitySearch) || (isset($this->isAdminSearch) && $this->isAdminSearch)) {
            if (request()->filled('r') && !request()->filled('l')) {
                // Administrative Division
                if (isset($this->admin) && !empty($this->admin)) {
                    $title .= ' ' . t('in') . ' ';
                    $title .= $this->admin->name;
                }
            } else {
                // City
                if (isset($this->city) && !empty($this->city)) {
                    $title .= ' ' . t('in') . ' ';
                    $title .= $this->city->name;
                }
            }
        }
        
        // Country
        $city = getCurrentCity();
        $country = getCurrentCountry();
        $title .= ', ' . $city.' '.$country;
        //dd($title);
        view()->share('title', $title);
        
        return $title;
    }
}
