<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banners;
use AdminHelper;
use App\Models\Parts;
use Illuminate\Support\Str;
use Illuminate\Support\Log;

class ManageBannerController extends Controller
{

    function getIndex()
    {
        if (!AdminHelper::isView()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        
        $request = request();
        $data = [];
        $data['page_title'] = 'Manage Banner';
        $data['limit'] = $limit = $request->get('limit', 20);
        $q = $request->get('q');
        $filter_column = $request->get('filter_column');
        $sorting = $request->get('sorting');

        $status = null;
        if (strtolower($q) === 'active') {
            $status = 1;
        } elseif (strtolower($q) === 'inactive') {
            $status = 0;
        }

        if ($filter_column) {
            $data['rows'] = Banners::when($q, function ($query) use ($q, $status) {
                    $query->whereRaw("(title LIKE '%" . $q . "%' OR description LIKE '%" . $q . "%')");
                    
                    if ($status !== null) {
                        $query->orWhere('status', $status);
                    }
                })
                ->orderBy($filter_column, $sorting)
                ->paginate($limit);
        } else {
            $data['rows'] = Banners::when($q, function ($query) use ($q, $status) {
                    $query->whereRaw("(title LIKE '%" . $q . "%' OR description LIKE '%" . $q . "%')");
                    
                    if ($status !== null) {
                        $query->orWhere('status', $status);
                    }
                })
                ->latest()
                ->paginate($limit);
        }

        return view('admin.banner.index', $data);
    }


    function getIndex_old()
    {
        try {
           
            if (!AdminHelper::isView()) {
                return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
            }
            
            $request = request();
            $data = [];
            $data['page_title'] = 'Manage Banner';
            $data['limit'] = $limit = (!empty($request->get('limit')) ? $request->get('limit') : 20);
            $q = $request->get('q');

            $filter_clumn = (!empty($request->get('filter_column')) ? $request->get('filter_column') : 'created_at');
            $sorting = (!empty($request->get('sorting')) ? $request->get('sorting') : 'desc');
            $data['rows'] = Banners::when($q, function ($query) use ($q) {
                $query->whereRaw("( title like '%" . $q . "%')");
                $query->whereRaw("( description like '%" . $q . "%')");
                if (stripos("active", $q) !== false) {
                    $query->orWhere('status', 1);
                } elseif (stripos("inactive", $q) !== false) {
                    $query->orWhere('status', 0);
                }
            })->orderBy($filter_clumn, $sorting)->paginate($limit);
            $data['userinfo'] = Banners::with('creator')->get();

            return view('admin.banner.index', $data);
        } catch (\Exception $e) {
            \Log::error('Error in getIndex: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while fetching data. Please try again later.');
        }
    }

    function getAdd()
    {
        try {
            if (!AdminHelper::isCreate()) {
                return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
            }
            $data = [];
            $data['page_title'] = 'Add Banner';
            $data['banners'] = Banners::where('status', 1)->get();

            return view('admin.banner.add', $data);
        } catch (\Exception $e) {
            \Log::error('Error in getAdd: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while fetching data for add. Please try again later.');
        }
    }

    function postAddSave(Request $request)
    {
        try {
           
            $request->validate([
                'title' => 'required|string|max:255',
                'order' => 'required|integer|max:4',
                'description' => 'required|string',
                'status' => 'required|integer|max:4',
                'image' => 'required|file|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);
            
            if (Banners::where('title', $request->input('title'))->exists()) {
                return redirect()->back()
                    ->withError('Banner title already exists! Please choose a different banner title.')
                    ->withInput();
            }

            $banner_image = '';

            if ($request->hasFile('image')) {
                $banner_image = $request->file('image');
                $name = 'banner-image-' . time() . '.' . $banner_image->getClientOriginalExtension();
                $destinationPath = public_path('admin/uploads/images/banners/');
                $banner_image->move($destinationPath, $name);
                $banner_image = 'admin/uploads/images/banners/' . $name;
            }
            Banners::insert([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'order' => $request->input('order'),
                'image'     => $banner_image,
                'status' => $request->input('status'),
                'created_by' => AdminHelper::myId(),
            ]);
            $return_url = (!empty($request->input('return_url')) ? $request->input('return_url') : AdminHelper::adminPath('admin') . '/banner');

            if ($request->input('submit') == 'Save') {
                return redirect($return_url)->withSuccess('Banner added successfully!');
            } else {
                return redirect()->back()->withSuccess('Banner added successfully!');
            }
        } catch (\Exception $e) {
            \Log::error('Error in postAddSave: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while save the data. Please try again later.');
        }
    }

    function getDetail($id)
    {
        try {
            if (!AdminHelper::isRead()) {
                return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
            }
            $data = [];
            $data['page_title'] = 'Banner Details';
            $data['row'] = Banners::find($id);
            $data['userinfo'] = Banners::with('creator')->first();

            return view('admin.banner.detail', $data);
        } catch (\Exception $e) {
            \Log::error('Error in getDetail: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while get details of the banner. Please try again later.');
        }
    }

    function getEdit($id)
    {
        try {
            if (!AdminHelper::isUpdate()) {
                return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
            }
            $data = [];
            $data['page_title'] = 'Edit Banner';
            $data['banners'] = Banners::where('status', 1)->get();
            $data['row'] = Banners::find($id);

            return view('admin.banner.edit', $data);
        } catch (\Exception $e) {
            \Log::error('Error in getEdit: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while get edit of the banner. Please try again later.');
        }
    }

    function postUpdateSave($id, Request $request)
    {
        try {
            //print_r('hii');exit;

            // if (Banners::where('title', $request->input('title'))->exists()) {
            //     return redirect()->back()
            //         ->withError('Banner title already exists! Please choose a different banner title.')
            //         ->withInput();
            // }
            $request->validate([
                'title' => 'required|string|max:255',
                'order' => 'required|integer',
                'description' => 'required|string',
                'status' => 'required|integer|max:4',
                'banner_image' => 'file|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);
            $data = Banners::find($id);
            $getUserId = AdminHelper::me();
            if ($request->hasFile('banner_image')) {
                $banner_image = $request->file('banner_image');
                $name = 'banner-image-' . time() . '.' . $banner_image->getClientOriginalExtension();
                $destinationPath = public_path('admin/uploads/images/banners/');
                $banner_image->move($destinationPath, $name);
                $setBanner_image = 'admin/uploads/images/banners/' . $name;

                $data->title = $request->input('title');
                $data->description = $request->input('description');
                $data->order = $request->input('order');
                $data->image = $setBanner_image;
                $data->status = $request->input('status');
                $data->updated_by = $getUserId->id;
                $data->save();
            }else{
                $data->title = $request->input('title');
                $data->description = $request->input('description');
                $data->order = $request->input('order');
                $data->status = $request->input('status');
                $data->updated_by = $getUserId->id;
                $data->save();
            }

            
            $return_url = (!empty($request->input('return_url')) ? $request->input('return_url') : AdminHelper::adminPath('admin') . '/banner');
            if ($request->input('submit') == 'Save') {
                return redirect($return_url)->withSuccess('Banner added successfully!');
            } else {
                return redirect()->back()->withSuccess('Banner added successfully!');
            }
        } catch (\Exception $e) {
            \Log::error('Error in postUpdateSave: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while edit data of the banner. Please try again later.');
        }
    }

    function getDelete($id)
    {
        try {
            if (!AdminHelper::isDelete()) {
                return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
            }
            if (!empty($id)) {
                Banners::find($id)->delete();
                return redirect()->back()->withSuccess('Banner deleted successfully!');
            }
        } catch (\Exception $e) {
            \Log::error('Error in getDelete: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while delete of the banner. Please try again later.');
        }
    }

    public function postActionSelected(Request $request)
    {
        try {
            if (!AdminHelper::isDelete()) {
                return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
            }
            $id_selected = $request->input('checkbox');
            $button_name = $request->input('button_name');
            $message = "No action taken";
            if (empty($id_selected)) {
                AdminHelper::redirect($_SERVER['HTTP_REFERER'], 'Please select at least one data!', 'warning');
            }

            if ($button_name == 'active') {
                Banners::whereIn('id', $id_selected)->update(['status' => '1', 'updated_at' => date('Y-m-d H:i:s')]);

                AdminHelper::insertLog("Updated data " . implode(',', $id_selected) . " by " . AdminHelper::myName() . " ip: " . $request->ip());

                $message = "The selected data activated successfully !";
                return redirect()->back()->withSuccess($message);
            }

            if ($button_name == 'inactive') {
                Banners::whereIn('id', $id_selected)->update(['status' => '0', 'updated_at' => date('Y-m-d H:i:s')]);

                AdminHelper::insertLog("Updated data " . implode(',', $id_selected) . " by " . AdminHelper::myName() . " ip: " . $request->ip());

                $message = "The selected data inactivated successfully !";
                return redirect()->back()->withSuccess($message);
            }

            return redirect()->back()->withError($message);
        } catch (\Exception $e) {
            \Log::error('Error in postActionSelected: ' . $e->getMessage());
            return redirect()->back()->withError('An error occurred while selected of the banner data. Please try again later.');
        }
    }
}
