<?php

namespace App\Plugins\watermark;

use App\Models\Setting;
use App\Helpers\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Prologue\Alerts\Facades\Alert;

class Watermark extends Payment
{
	/**
	 * @param $image
	 * @return null
	 */
	public static function apply($image)
	{
		// Insert watermark at bottom-right corner with 10px offset
		try {
			$watermark = config('settings.upload.watermark');
			if (!empty($watermark) and Storage::exists($watermark)) {
				$image->insert(Storage::get($watermark), config('watermark.position'), (int)config('watermark.position-x'), (int)config('watermark.position-y'));
			}
		} catch (\Exception $e) {
			return null;
		}
		
		return $image;
	}
	
	/**
	 * @param $value
	 * @param $setting
	 * @return bool
	 */
	public static function setWatermarkValue($value, $setting)
	{
		$attribute_name = 'watermark';
		$destination_path = 'app/logo';
		
		// If 'watermark' value doesn't exist, don't make the upload and save data
		if (!isset($value[$attribute_name])) {
			return $value;
		}
		
		// If the image was erased
		if (empty($value[$attribute_name])) {
			// Delete the image from disk
			if (isset($setting->value) && isset($setting->value[$attribute_name])) {
				Storage::delete($setting->value[$attribute_name]);
			}
			
			// Set null in the database column
			$value[$attribute_name] = null;
			
			return $value;
		}
		
		
		// If a base64 was sent, store it in the db
		if (starts_with($value[$attribute_name], 'data:image')) {
			try {
				// Get file extension
				$extension = (is_png($value[$attribute_name])) ? 'png' : 'jpg';
				
				// Make the image (Size: 150x150)
				$image = Image::make($value[$attribute_name])->resize((int)config('watermark.width'), (int)config('watermark.height'), function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->encode('png', (int)config('watermark.quality'));
			} catch (\Exception $e) {
				Alert::error($e->getMessage())->flash();
				
				$value[$attribute_name] = null;
				
				return $value;
			}
			
			// Generate a filename.
			$filename = uniqid('watermark-') . '.' . $extension;
			
			// Store the image on disk.
			Storage::put($destination_path . '/' . $filename, $image->stream());
			
			// Save the path to the database
			$value[$attribute_name] = $destination_path . '/' . $filename;
		} else {
			// Get, Transform and Save the path to the database
			if (!Storage::exists($value[$attribute_name])) {
				$value[$attribute_name] = null;
			} else {
				$value[$attribute_name] = $destination_path . last(explode($destination_path, $value[$attribute_name]));
			}
		}
		
		return $value;
	}
	
	/**
	 * @return array
	 */
	public static function getOptions()
	{
		$options = [];
		$setting = DB::table('settings')->where('key', 'upload')->first();
		if (!empty($setting)) {
			$options[] = (object)[
				'name'     => mb_ucfirst(trans('admin::messages.settings')),
				'url'      => 'https://www.classifiedzoo.com/admin/settings/' . $setting->id . '/edit',
				'btnClass' => 'btn-info',
			];
		}
		
		return $options;
	}
	
	/**
	 * @return bool
	 */
	public static function installed()
	{
		return File::exists(plugin_path('watermark', 'installed'));
	}
	
	/**
	 * @return bool
	 */
	public static function install()
	{
		// Remove the plugin entry
		self::uninstall();
		
		try {
			// Create plugin Installed file
			File::put(plugin_path('watermark', 'installed'), '');
			
			return true;
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
		}
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	public static function uninstall()
	{
		try {
			// Remove plugin Installed file
			File::delete(plugin_path('watermark', 'installed'));
			
			return true;
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
		}
		
		return false;
	}
	
	/**
	 * @param string $value
	 * @return string
	 */
	public static function getFieldData($value = '')
	{
		if (!empty($value)) {
			$value = $value . ",\n\t";
		}
		$value = $value . '{"name":"watermark","label":"' . cleanAddSlashes(trans('watermark::messages.Watermark')) . '","type":"image","upload":true,"disk":"public","default":"","hint":"' . cleanAddSlashes(trans('watermark::messages.Watermark (extension: png,jpg)')) . '","wrapperAttributes":{"class":"form-group col-md-6"},"plugin":"watermark","disableTrans":"true"}';
		
		return $value;
	}
}
