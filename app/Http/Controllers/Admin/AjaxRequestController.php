<?php 
namespace App\Http\Controllers\Admin;

use \App\Helpers\AdminHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\FoodItem;

class AjaxRequestController extends Controller
{
	function getCities($country_id)
	{
		if($country_id)
		{
			return City::where('country_id', $country_id)->where('city_status', 1)->get();
		}
	}

	function getCompanies($country_id, $city_id)
	{
		if($city_id)
		{
			return Company::where('country_id', $country_id)->where('city_id', $city_id)->where('company_status', 1)->get();
		}
	}

	function getFooditems($cat_id)
	{
		if($cat_id)
		{
			return FoodItem::select('id','item_name_fr','item_name_ar','price_chf','price_bhd','category_id')->where('status', 1)->where('category_id', $cat_id)->get();
		}
	}
}
