<?php 
namespace App\Http\Controllers\Admin;

use \App\Helpers\AdminHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Models\AdminUser;
use App\Models\BlogPages;

class AdminController extends Controller
{
    function getIndex()
    {     
        $data = [];
        $data['page_title'] = 'Dashboard';
        
        return view('admin.home', $data);
    }

    function test()
    {        
        $data = [];
        $data['page_title'] = 'Dashboard';
            
        return view('admin.test_page', $data);
    }

    public function getLogin()
    {  
        return view('auth.login'); 
        // if (AdminHelper::myId()) {
        //     return redirect(AdminHelper::adminPath('dashboard'));
        // }else{
        //     return view('welcome');
        // }

        
        //return view('admin.auth.login');
    }
    public function getAdminLogin()
    {     
        return view('admin.auth.login');
    }
    

    public function postLogin()
    {

        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:'.'admin_users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $msg_str = $message[0];
            
            return redirect()->back()->with('message', $msg_str );
        }

        $email = Request::input("email");
        $password = Request::input("password");
        $users = AdminUser::where("email", $email)->first(); 
            
        if(!empty($users)){
            if (\Hash::check($password, $users->password)) {
                
                if($users->status==1)
                {
                    
                    $photo = ($users->photo) ? asset($users->photo) : asset('admin/images/avatar.jpg');
                    $priv = DB::table("admin_privileges")->where("id", $users->id_admin_privileges)->first();

                    
                    Session::put('admin_id', $users->id);                
                    Session::put('admin_name', $users->name);
                    Session::put('admin_photo', $photo);        
                    Session::put("admin_privileges", $users->id_admin_privileges);    
                    Session::put('admin_privileges_name', $priv->name);            
                    Session::put('admin_lock', 0);                
                    Session::put("appname", 'Admin');
                    
                    return redirect(AdminHelper::adminPath('dashboard'));
                }else{
                    return redirect()->route('getLogin')->with('message', 'Sorry your account has been deactivated !');
                }
            } else {
                return redirect()->route('getLogin')->with('message', 'Sorry your password is wrong !');
            }
        }else{
            return redirect()->route('getLogin')->with('message', 'Sorry your password is wrong !');
        }
        
    }
    public function postAdminLogin()
    {

        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:'.'admin_users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $msg_str = $message[0];
            
            return redirect()->back()->with('message', $msg_str );
        }

        $email = Request::input("email");
        $password = Request::input("password");
        $users = AdminUser::where("email", $email)->first(); 
            
        if(!empty($users)){
                
            if($users->status==1)
            {
                $photo = ($users->photo) ? asset($users->photo) : asset('admin/images/avatar.jpg');
                $priv = DB::table("admin_privileges")->where("id", $users->id_admin_privileges)->first();

                
                Session::put('admin_id', $users->id);                
                Session::put('admin_name', $users->name);
                Session::put('admin_photo', $photo);        
                Session::put("admin_privileges", $users->id_admin_privileges);    
                Session::put('admin_privileges_name', $priv->name);            
                Session::put('admin_lock', 0);                
                Session::put("appname", 'Admin');
                return redirect(AdminHelper::adminPath('admin/dashboard'));
            }else{
                return redirect()->route('getAdminLogin')->with('message', 'Sorry your account has been deactivated !');
            }
            
        }else{
            return redirect()->route('getAdminLogin')->with('message', 'Sorry your password is wrong !');
        }
        
    }

    public function getForgot()
    {
        if (AdminHelper::myId()) {
            return redirect(AdminHelper::adminPath('dashboard'));
        }

        return view('admin.auth.forgot');
    }

    public function postForgot()
    {
        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:admin_users',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->withError(implode(', ', $message));
        }

        $rand_string = Str::random(5);
        $password = \Hash::make($rand_string);

        $email = Request::input("email");

        AdminUser::where('email', $email)->update(['password' => $password]);

        $appname = AdminHelper::getSetting('appname');
        $user = AdminHelper::first('admin_users', ['email' => $email]);
        $user->password = $rand_string;
                

        return redirect()->route('getLogin')->withSuccess('We have sent new password to your email, check inbox or spambox !');
    }

    public function getLogout()
    {

        $me = AdminHelper::me();
        AdminHelper::insertLog((!empty($me)?$me->email:'').' logout');

        Session::flush();

        return redirect()->route('getLogin')->with('message', 'Thank You, See You Later !');
    }

    public function download_file()
    {
      //  dd($request->all());
        $value = request()->get('image');
        $file = public_path($value);
        if(\Storage::exists($file) || file_exists($file)){
            //$file = public_path($value);
            $name = basename($file);
            return response()->download($file, $name);
        }else{
            return redirect()->back()->with('error','File not found');
        }
        
    }

    public function delete_file()
    {
        $file = request()->get('image');
        $file = public_path($file);
        if(\Storage::exists($file) || file_exists($file)){
            //$file = public_path($file);
            unlink($file);
        }
        if(!empty(request()->get('id')) && !empty(request()->get('column')) && !empty(request()->get('table')))
        {
            DB::table(request()->get('table'))->where('id', request()->get('id'))->update([request()->get('column')=>NULL]);
        }

        return redirect()->back()->withSuccess('File deleted successfully!');
    }
}
