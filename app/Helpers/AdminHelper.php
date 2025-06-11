<?php

namespace App\Helpers;

use Cache;
use DB;
use Image;
use Request;
use Route;
use Schema;
use Session;
use Storage;
use Validator;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\Settings;
use DateTime;
use App\Models\UserProfile;
use App\Models\HomepageSetting;
use App\Models\UserAddress;
use App\Models\MasterDesign;
use App\Models\DesignAttribute;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Option;
use App\Models\OptionValue;



class AdminHelper
{
    public static function echoSelect2Mult($values, $table, $id, $name)
    {
        $values = explode(",", $values);
        return implode(", ", DB::table($table)->whereIn($id, $values)->pluck($name)->toArray());

    }

    public static function uploadBase64($value, $id = null)
    {
        if (! self::myId()) {
            $userID = 0;
        } else {
            $userID = self::myId();
        }

        if ($id) {
            $userID = $id;
        }

        $filedata = base64_decode($value);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $filedata, FILEINFO_MIME_TYPE);
        @$mime_type = explode('/', $mime_type);
        @$mime_type = $mime_type[1];
        if ($mime_type) {
            $filePath = 'uploads/' . $userID . '/' . date('Y-m');
            Storage::makeDirectory($filePath);
            $filename = md5(str_random(5)) . '.' . $mime_type;
            if (Storage::put($filePath . '/' . $filename, $filedata)) {
                self::resizeImage($filePath . '/' . $filename);

                return $filePath . '/' . $filename;
            }
        }
    }

    public static function uploadFile($name, $encrypt = false, $resize_width = null, $resize_height = null, $id = null, $watermark = false)
    {
        if (Request::hasFile($name)) {
            if (! self::myId()) {
                $userID = 0;
            } else {
                $userID = self::myId();
            }

            if ($id) {
                $userID = $id;
            }

            $file = Request::file($name);
            $ext = $file->getClientOriginalExtension();
            $filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filesize = $file->getSize() / 1024;
            $file_path = 'uploads/' . $userID . '/' . date('Y-m');

            //Create Directory Monthly
            Storage::makeDirectory($file_path);

            if ($encrypt == true) {
                $filename = md5(str_random(5)) . '.' . $ext;
            } else {
                $filename = str_slug($filename, '_') . '.' . $ext;
            }

            if (Storage::putFileAs($file_path, $file, $filename)) {
                if ($watermark == true) {
                    $logo = storage_path('app/' . config('settings.logo'));
                    $img = Image::make(storage_path('app/' . $file_path . '/' . $filename));
                    $img->insert($logo, 'bottom-right', 10, 10);
                    $img->save(storage_path('app/' . $file_path . '/' . $filename));
                }
                self::resizeImage($file_path . '/' . $filename, $resize_width, $resize_height);

                return $file_path . '/' . $filename;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private static function resizeImage($fullFilePath, $resize_width = null, $resize_height = null, $qty = 100, $thumbQty = 75)
    {
        $images_ext = config('crudbooster.IMAGE_EXTENSIONS', 'jpg,png,gif,bmp');
        $images_ext = explode(',', $images_ext);

        $filename = basename($fullFilePath);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file_path = trim(str_replace($filename, '', $fullFilePath), '/');

        $file_path_thumbnail = 'uploads_thumbnail/' . date('Y-m');
        Storage::makeDirectory($file_path_thumbnail);

        if (in_array(strtolower($ext), $images_ext)) {

            if ($resize_width && $resize_height) {
                $img = Image::make(storage_path('app/' . $file_path . '/' . $filename));
                $img->fit($resize_width, $resize_height);
                $img->save(storage_path('app/' . $file_path . '/' . $filename), $qty);
            } elseif ($resize_width && ! $resize_height) {
                $img = Image::make(storage_path('app/' . $file_path . '/' . $filename));
                $img->resize($resize_width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/' . $file_path . '/' . $filename), $qty);
            } elseif (! $resize_width && $resize_height) {
                $img = Image::make(storage_path('app/' . $file_path . '/' . $filename));
                $img->resize(null, $resize_height, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/' . $file_path . '/' . $filename), $qty);
            } else {
                $img = Image::make(storage_path('app/' . $file_path . '/' . $filename));
                if ($img->width() > 1300) {
                    $img->resize(1300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $img->save(storage_path('app/' . $file_path . '/' . $filename), $qty);
            }

            $img = Image::make(storage_path('app/' . $file_path . '/' . $filename));
            $img->fit(350, 350);
            $img->save(storage_path('app/' . $file_path_thumbnail . '/' . $filename), $thumbQty);
        }
    }

    public static function getSetting($name)
    {

        $query = DB::table('admin_settings')->select($name)->first();
        if (!empty($query)) {
            Cache::forever('setting_' . $name, $query->$name);

            return $query->$name;
        }
    }


    public static function insert($table, $data = [])
    {
        $data['id'] = DB::table($table)->max('id') + 1;
        if (! $data['created_at']) {
            if (Schema::hasColumn($table, 'created_at')) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
        }

        if (DB::table($table)->insert($data)) {
            return $data['id'];
        } else {
            return false;
        }
    }

    public static function first($table, $id)
    {
        $table = self::parseSqlTable($table)['table'];
        if (is_array($id)) {
            $first = DB::table($table);
            foreach ($id as $k => $v) {
                $first->where($k, $v);
            }

            return $first->first();
        } else {
            $pk = self::pk($table);

            return DB::table($table)->where($pk, $id)->first();
        }
    }

    public static function get($table, $string_conditions = null, $orderby = null, $limit = null, $skip = null)
    {
        $table = self::parseSqlTable($table);
        $table = $table['table'];
        $query = DB::table($table);
        if ($string_conditions) {
            $query->whereraw($string_conditions);
        }
        if ($orderby) {
            $query->orderbyraw($orderby);
        }
        if ($limit) {
            $query->take($limit);
        }
        if ($skip) {
            $query->skip($skip);
        }

        return $query->get();
    }

    public static function me()
    {
        return AdminUser::where('id', Session::get('admin_id'))->first();
    }

    public static function myId()
    {
        return Session::get('admin_id');
    }

    public static function isSuperadmin()
    {
        //return Session::get('admin_is_superadmin');
        return DB::table('admin_privileges')->find(self::myPrivilegeId())->is_superadmin;
    }

    public static function myName()
    {
        return Session::get('admin_name');
    }

    public static function myPhoto()
    {

        $profiledata = AdminUser::find(AdminHelper::myId());


        if ($profiledata->photo) {

            return $profiledata->photo;
        }


        return Session::get('admin_photo');
    }

    public static function myPrivilege()
    {
        $roles = Session::get('admin_privileges_roles');
        if ($roles) {
            foreach ($roles as $role) {
                if ($role->path == AdminHelper::getModulePath()) {
                    return $role;
                }
            }
        }
    }

    public static function myPrivilegeId()
    {
        return Session::get('admin_privileges');
    }

    public static function myPrivilegeName()
    {
        return Session::get('admin_privileges_name');
    }

    public static function isLocked()
    {
        return Session::get('admin_lock');
    }

    public static function redirectBack($message, $type = 'warning')
    {

        if (Request::ajax()) {
            $resp = response()->json(['message' => $message, 'message_type' => $type, 'redirect_url' => $_SERVER['HTTP_REFERER']])->send();
            exit;
        } else {
            $resp = redirect()->back()->with(['message' => $message, 'message_type' => $type]);
            Session::driver()->save();
            $resp->send();
            exit;
        }
    }

    public static function redirect($to, $message, $type = 'warning')
    {

        if (Request::ajax()) {
            $resp = response()->json(['message' => $message, 'message_type' => $type, 'redirect_url' => $to])->send();
            exit;
        } else {
            $resp = redirect($to)->with(['message' => $message, 'message_type' => $type]);
            Session::driver()->save();
            $resp->send();
            exit;
        }
    }

    public static function isView()
    {

        $session = self::getPrivilegeRoles();
        foreach ($session as $menu) {
            $url_path = '';
            switch ($menu->type) {
                case 'Route':
                    $url_path = route($menu->path);
                    break;
                default:
                case 'URL':
                    $url_path = $menu->path;
                    break;
                case 'Controller & Method':
                    $url_path = action($menu->path);
                    break;
                case 'Module':
                case 'Statistic':
                    $url_path = self::adminPath($menu->path);
                    break;
            }
            $url_path = trim(str_replace(url('/'), '', $url_path), "/");
            if ($url_path == self::getModulePath()) {
                return (bool) $menu->is_visible;
            }
        }
    }

    public static function isUpdate()
    {

        $session = self::getPrivilegeRoles();
        foreach ($session as $menu) {
            $url_path = '';
            switch ($menu->type) {
                case 'Route':
                    $url_path = route($menu->path);
                    break;
                default:
                case 'URL':
                    $url_path = $menu->path;
                    break;
                case 'Controller & Method':
                    $url_path = action($menu->path);
                    break;
                case 'Module':
                case 'Statistic':
                    $url_path = self::adminPath($menu->path);
                    break;
            }
            $url_path = trim(str_replace(url('/'), '', $url_path), "/");
            if ($url_path == self::getModulePath()) {
                return (bool) $menu->is_edit;
            }
        }
    }

    public static function isCreate()
    {

        $session = self::getPrivilegeRoles();
        if (!empty($session)) {
            foreach ($session as $menu) {
                $url_path = '';
                switch ($menu->type) {
                    case 'Route':
                        $url_path = route($menu->path);
                        break;
                    default:
                    case 'URL':
                        $url_path = $menu->path;
                        break;
                    case 'Controller & Method':
                        $url_path = action($menu->path);
                        break;
                    case 'Module':
                    case 'Statistic':
                        $url_path = self::adminPath($menu->path);
                        break;
                }
                $url_path = trim(str_replace(url('/'), '', $url_path), "/");
                if ($url_path == self::getModulePath()) {
                    return (bool) $menu->is_create;
                }
            }
        }
        return false;
    }

    public static function isRead()
    {

        $session = self::getPrivilegeRoles();
        foreach ($session as $menu) {
            $url_path = '';
            switch ($menu->type) {
                case 'Route':
                    $url_path = route($menu->path);
                    break;
                default:
                case 'URL':
                    $url_path = $menu->path;
                    break;
                case 'Controller & Method':
                    $url_path = action($menu->path);
                    break;
                case 'Module':
                case 'Statistic':
                    $url_path = self::adminPath($menu->path);
                    break;
            }
            $url_path = trim(str_replace(url('/'), '', $url_path), "/");
            if ($url_path == self::getModulePath()) {
                return (bool) $menu->is_read;
            }
        }
    }

    public static function isDelete()
    {

        $session = self::getPrivilegeRoles();
        foreach ($session as $menu) {
            $url_path = '';
            switch ($menu->type) {
                case 'Route':
                    $url_path = route($menu->path);
                    break;
                default:
                case 'URL':
                    $url_path = $menu->path;
                    break;
                case 'Controller & Method':
                    $url_path = action($menu->path);
                    break;
                case 'Module':
                case 'Statistic':
                    $url_path = self::adminPath($menu->path);
                    break;
            }
            $url_path = trim(str_replace(url('/'), '', $url_path), "/");
            if ($url_path == self::getModulePath()) {
                return (bool) $menu->is_delete;
            }
        }
    }

    public static function isCRUD()
    {

        $session = self::getPrivilegeRoles();
        foreach ($session as $menu) {
            $url_path = '';
            switch ($menu->type) {
                case 'Route':
                    $url_path = route($menu->path);
                    break;
                default:
                case 'URL':
                    $url_path = $menu->path;
                    break;
                case 'Controller & Method':
                    $url_path = action($menu->path);
                    break;
                case 'Module':
                case 'Statistic':
                    $url_path = self::adminPath($menu->path);
                    break;
            }
            $url_path = trim(str_replace(url('/'), '', $url_path), "/");
            if ($url_path == self::getModulePath()) {
                if ($menu->is_visible && $menu->is_create && $menu->is_read && $menu->is_edit && $menu->is_delete) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public static function getPrivilegeRoles()
    {
        $roles = DB::table('admin_privileges_roles')->where('id_admin_privileges', self::myPrivilegeId())->join('admin_menus', 'admin_menus.id', '=', 'id_admin_menus')->select('admin_menus.name', 'admin_menus.path', 'admin_menus.type', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();
        return $roles;
    }

    public static function getCurrentModule()
    {
        $modulepath = self::getModulePath();

        if (Cache::has('moduls_' . $modulepath)) {
            return Cache::get('moduls_' . $modulepath);
        } else {

            $module = DB::table('cms_moduls')->where('path', self::getModulePath())->first();

            
            return ($module) ?: $modulepath;
        }
    }

    public static function getCurrentDashboardId()
    {
        if (Request::get('d') != null) {
            Session::put('currentDashboardId', Request::get('d'));
            Session::put('currentMenuId', 0);

            return Request::get('d');
        } else {
            return Session::get('currentDashboardId');
        }
    }

    public static function getCurrentMenuId()
    {
        if (Request::get('m') != null) {
            Session::put('currentMenuId', Request::get('m'));
            Session::put('currentDashboardId', 0);

            return Request::get('m');
        } else {
            return Session::get('currentMenuId');
        }
    }

    public static function sidebarMenu()
    {
        $menu_active = DB::table('admin_menus as adm')->whereRaw("id IN (select id_admin_menus from " . env('DB_PREFIX') . "admin_privileges_roles where id_admin_privileges = '" . self::myPrivilegeId() . "')")->where('parent_id', 0)->where('is_active', 1)->orderby('sorting', 'asc')->select('adm.*')->get();

        foreach ($menu_active as &$menu) {

            try {
                switch ($menu->type) {
                    case 'Route':
                        $url = route($menu->path);
                        break;
                    default:
                    case 'URL':
                        $url = $menu->path;
                        break;
                    case 'Controller & Method':
                        $url = action($menu->path);
                        break;
                    case 'Module':
                    case 'Statistic':
                        $url = self::adminPath($menu->path);
                        break;
                }

                $menu->is_broken = false;
            } catch (\Exception $e) {
                $url = "#";
                $menu->is_broken = true;
            }

            $menu->url = $url;
            $menu->url_path = trim(str_replace(url('/'), '', $url), "/");

            $child = DB::table('admin_menus')->whereRaw("id IN (select id_admin_menus from " . env('DB_PREFIX') . "admin_privileges_roles where id_admin_privileges = '" . self::myPrivilegeId() . "')")->where('is_active', 1)->where('parent_id', $menu->id)->select('admin_menus.*')->orderby('sorting', 'asc')->get();
            if (count($child)) {

                foreach ($child as &$c) {

                    try {
                        switch ($c->type) {
                            case 'Route':
                                $url = route($c->path);
                                break;
                            default:
                            case 'URL':
                                $url = $c->path;
                                break;
                            case 'Controller & Method':
                                $url = action($c->path);
                                break;
                            case 'Module':
                            case 'Statistic':
                                $url = self::adminPath($c->path);
                                break;
                        }
                        $c->is_broken = false;
                    } catch (\Exception $e) {
                        $url = "#";
                        $c->is_broken = true;
                    }

                    $c->url = $url;
                    $c->url_path = trim(str_replace(url('/'), '', $url), "/");
                }

                $menu->children = $child;
            }
        }

        return $menu_active;
    }

    public static function getModulePath()
    {
        // Check to position of admin_path
        if (config("app.admin_path")) {
            $adminPathSegments = explode('/', Request::path());
            $no = 1;
            foreach ($adminPathSegments as $path) {
                if ($path == config("app.admin_path")) {
                    $segment = $no + 1;
                    break;
                }
                $no++;
            }
            return config("app.admin_path") . '/' . Request::segment($segment);
        } else {
            $segment = 1;
            return Request::segment($segment);
        }
    }

    public static function deleteConfirm($redirectTo)
    {
        echo "Swal.fire({
                    title: \"" . cbLang('delete_title_confirm') . "\",   
                    text: \"" . cbLang('delete_description_confirm') . "\",  
                    icon: \"warning\",
                    showCancelButton: !0,
                    confirmButtonText: \"Yes, delete it!\",
                    cancelButtonText: \"No, cancel!\",
                    confirmButtonClass: \"btn btn-primary w-xs me-2 mt-2\",
                    cancelButtonClass: \"btn btn-danger w-xs mt-2\",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                }).then(function (t) {
                    t.isConfirmed?location.href=\"$redirectTo\":\"\" });";
    }

    public static function adminPath($path = '')
    {
        return url(config('app.admin_path') . '/' . $path);
    }

    public static function getCurrentId()
    {
        $id = Session::get('current_row_id');
        $id = intval($id);
        $id = (! $id) ? Request::segment(4) : $id;
        $id = intval($id);

        return $id;
    }

    public static function insertLog($description, $details = '')
    {
        $a = [];
        $a['created_at'] = date('Y-m-d H:i:s');
        $a['ipaddress'] = $_SERVER['REMOTE_ADDR'];
        $a['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        $a['url'] = Request::url();
        $a['description'] = $description;
        $a['details'] = $details;
        $a['id_cms_users'] = self::myId();
        DB::table('blog_logs')->insert($a);
    }

}
