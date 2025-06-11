<?php 
namespace App\Http\Controllers\Admin;

use \App\Helpers\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Models\Settings;
use App\Models\EmailSetting;

class SettingsController extends Controller
{
	function getGeneralSettings()
	{
		if (!AdminHelper::isView() && !AdminHelper::isUpdate() && !AdminHelper::isRead()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
		$data = [];
		$data['page_title'] = "General Settings";
		$data['row'] = Settings::find(1);
		//dd($data['row']);

		return view('admin.settings.general', $data);
	}

	function postSaveGeneralSettings(Request $request)
	{
		/*if (!AdminHelper::isUpdate()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }*/
		$request->validate([
			'site_title' => 'required|string|max:250',
			'logo' => 'mimes:jpeg,jpg,png,gif,svg|max:2000',
			'footer_logo' => 'mimes:jpeg,jpg,png,gif,svg|max:2000',
			'favicon' => 'mimes:jpeg,jpg,png,svg,ico|max:2000',			
			'site_email' => 'email|max:255|nullable',
			'site_phone_number' => 'string|max:50|nullable',
			'site_phone_actual' => 'string|max:50|nullable',
			'site_address' => 'string|max:250|nullable',			
			'facebook_link' => 'url|max:250|max:250|nullable',
			'instagram_link' => 'url|max:250|max:250|nullable',
			'twitter_link' => 'url|max:250|max:250|nullable',
			'linkedin_link' => 'url|max:250|max:250|nullable',
			//'commission_value'=>'nullable|numeric',
            //'authorized_signature' => 'mimes:jpeg,jpg,png,gif,svg|max:2000',
			// 'app_link_android' => 'url|max:250|max:250|nullable',
			// 'app_link_ios' => 'url|max:250|max:250|nullable',
            // 'contact_email' => 'email|max:255',
            // 'contact_email_additional' => 'email|max:255',
            // 'contact_phone_number' => 'string|max:50',
            // 'contact_phone_number_additional'=>'string|max:50',
			//'youtube_link' => 'string|max:250',			
		]);

		$settings = Settings::find(1);
		$logo = '';
		$footer_logo = '';
		$favicon = '';
		$home_banner = '';
		$created_by = AdminHelper::myId();
		$updated_by = AdminHelper::myId();
		$user_ip = $request->ip();
		$date = date('Y-m-d H:i:s');

		/*if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = 'logo-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/uploads/images/');
            $image->move($destinationPath, $name);
            $logo = 'storage/uploads/images/'.$name;
        }
*/
         
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = 'logo-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/site/logo/');
            $image->move($destinationPath, $name);
            $logo = 'uploads/site/logo/'.$name;
        }
        if ($request->hasFile('footer_logo')) {
            $image = $request->file('footer_logo');
            $name = 'footer_logo-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/site/logo/');
            $image->move($destinationPath, $name);
            $footer_logo = 'uploads/site/logo/'.$name;
        }
        
         if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $name = 'favicon-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/site/favicon/');
            $image->move($destinationPath, $name);
            $favicon = 'uploads/site/favicon/'.$name;
        }

         if ($request->hasFile('home_banner')) {
            $image = $request->file('home_banner');
            $name = 'home_banner-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/site/banner/');
            $image->move($destinationPath, $name);
            $home_banner = 'uploads/site/banner/'.$name;
        }
        if ($request->hasFile('authorized_signature')) {
            $image = $request->file('authorized_signature');
            $name = 'authorized-sign-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/site/authorize-signature/');
            $image->move($destinationPath, $name);
            $authorized_sign = 'uploads/site/authorize-signature/'.$name;
        }
        if ($request->hasFile('po_logo')) {
            $image = $request->file('po_logo');
            $name = 'po-logo-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/site/po-logo/');
            $image->move($destinationPath, $name);
            $po_logo = 'uploads/site/po-logo/'.$name;
        }
        

      /*  if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $name = 'favicon-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/uploads/images/');
            $image->move($destinationPath, $name);
            $favicon = 'storage/uploads/images/'.$name;
        }*/

		if(!empty($settings))
		{
			$settings->appname = $request->input('site_title');
			if(!empty($logo))
			{
				$settings->logo = $logo;	
			}
			if(!empty($footer_logo))
			{
				$settings->footer_logo = $footer_logo;	
			}
			if(!empty($favicon))
			{
				$settings->favicon = $favicon;
			}	
			if(!empty($home_banner))
			{
				$settings->home_banner = $home_banner;
			}	
            if(!empty($authorized_sign))
			{
				$settings->authorized_signature = $authorized_sign;	
			}
            if(!empty($po_logo))
			{
				$settings->po_logo = $po_logo;	
			}
					
			$settings->site_email = $request->input('site_email');
			$settings->site_address = $request->input('site_address');            
			// $settings->map_link = $request->input('map_link');
			$settings->site_phone_number = $request->input('site_phone_number');			
			$settings->facebook_link = $request->input('facebook_link');
			$settings->twitter_link = $request->input('twitter_link');
			$settings->instagram_link = $request->input('instagram_link');
			//$settings->linkedin_link = $request->input('linkedin_link');
			$settings->youtube_link = $request->input('youtube_link');			
			// $settings->app_link_ios = $request->input('app_link_ios');			
			// $settings->app_link_android = $request->input('app_link_android');	
            // $settings->contact_email_additional = $request->input('contact_email_additional');	
            // $settings->contact_phone_number = $request->input('contact_phone_number'); 	
            // $settings->contact_phone_number_additional = $request->input('contact_phone_number_additional');
            // $settings->contact_email = $request->input('contact_email');
			// $settings->updated_by = $updated_by;
			//$settings->commission_type = $request->input('commission_type');
			//$settings->commission_value = $request->input('commission_value');
			$settings->updated_at = $date;
			$settings->save();
		}else{
			Settings::insert([
				'appname' => $request->input('site_title'),
				'logo' => $logo,
				'footer_logo' => $footer_logo,
				'favicon' => $favicon,
				'home_banner' => $home_banner,
				'site_email' => $request->input('site_email'),
				'site_address' => $request->input('site_address'),
                'comment_instruction' => $request->input('comment_instruction'),
				// 'map_link' => $request->input('map_link'),
				'site_phone_number' => $request->input('site_phone_number'),
				'site_about' => NULL,
				'facebook_link' => $request->input('facebook_link'),
				'twitter_link' => $request->input('twitter_link'),
				'instagram_link' => $request->input('instagram_link'),
				'linkedin_link' => $request->input('linkedin_link'),
                'authorized_signature' => $authorized_sign,
                'po_logo' => $po_logo,
                // 'contact_email'=>$request->input('contact_email'),
                // 'contact_email_additional'=>$request->input('contact_email_additional'),
                // 'contact_phone_number'=>$request->input('contact_phone_number'),
                // 'contact_phone_number_additional'=>$request->input('contact_phone_number_additional'),
				//'youtube_link' => $request->input('youtube_link'),				
				'maintenance_mode' => 0,
				// 'created_by' => $created_by,
				//'commission_type'=>$request->input('commission_type'),
				//'commission_value'=>$request->input('commission_value'),
				'user_ip' => $user_ip,
				'created_at' => $date
			]);
			
		}
		/*if($request->input('slot_duration')>0)
		{
			$slot_duration= $request->input('slot_duration');
			AdminHelper::generateMasterSlots($slot_duration);
		}*/

		return redirect()->back()->withSuccess('Settings updated successfully!');
	}
	
	function getEmailSettings()
	{
		/*if (!AdminHelper::isView() && !AdminHelper::isUpdate() && !AdminHelper::isRead()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }*/
		$data = [];
		$data['page_title'] = "Email Settings";
		$data['row'] = EmailSetting::find(1);

		return view('admin.settings.email', $data);
	}

	function postSaveEmailSettings(Request $request)
	{
		/*if (!AdminHelper::isUpdate()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }*/
		$request->validate([
			'email_sender' => 'required|email|max:250',			
			'mail_driver' => 'required|max:250',			
			'smtp_host' => 'required|max:250',			
			'smtp_port' => 'required|max:250',			
			'smtp_username' => 'required|max:250',			
			'smtp_password' => 'required|max:250',						
		]);

		$email_settings = EmailSetting::find(1);				
		$date = date('Y-m-d H:i:s');

		if(!empty($email_settings))
		{
			$email_settings->email_sender = $request->input('email_sender');
			$email_settings->mail_driver = $request->input('mail_driver');
			$email_settings->smtp_host = $request->input('smtp_host');
			$email_settings->smtp_port = $request->input('smtp_port');
			$email_settings->smtp_username = $request->input('smtp_username');
			$email_settings->smtp_password = $request->input('smtp_password');
			
			$email_settings->updated_at = $date;
			$email_settings->save();
		}else{
			EmailSetting::insert([
				'email_sender' => $request->input('email_sender'),								
				'mail_driver' => $request->input('mail_driver'),								
				'smtp_host' => $request->input('smtp_host'),								
				'smtp_port' => $request->input('smtp_port'),								
				'smtp_username' => $request->input('smtp_username'),								
				'smtp_password' => $request->input('smtp_password'),								
				'created_at' => $date
			]);
		}

		return redirect()->back()->withSuccess('Email settings updated successfully!');
	}
}