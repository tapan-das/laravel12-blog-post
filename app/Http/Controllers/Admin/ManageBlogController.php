<?php

namespace App\Http\Controllers\Admin;

use AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\User;
use App\Models\BlogPages;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ManageBlogController extends Controller
{
    function getIndex()
    {
        if (!AdminHelper::isView()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $request = request();
        $data = [];
        $data['page_title'] = 'Manage Blog';
        $data['limit'] = $limit = (!empty($request->get('limit')) ? $request->get('limit') : 20);
        $q = $request->get('q');

        $filter_clumn = $request->get('filter_column');
        $sorting = $request->get('sorting');
        if ($filter_clumn != '') {
            $data['rows'] = BlogPages::when($q, function ($query) use ($q) {
                $query->whereRaw("( page_title like '%" . $q . "%' or meta_title like '%" . $q . "%' )");
            })->orderBy($filter_clumn, $sorting)->paginate($limit);
        } else {
            $data['rows'] = BlogPages::when($q, function ($query) use ($q) {
                $query->whereRaw("( page_title like '%" . $q . "%' or meta_title like '%" . $q . "%' )");
            })->latest()->paginate($limit);
        }

        return view('admin.blog_management.index', $data);
    }

    function getAdd()
    {
        if (!AdminHelper::isCreate()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $data = [];
        $data['page_title'] = 'Add Blog';
        return view('admin.blog_management.add', $data);
    }

    function postAddSave(Request $request)
    {
        if (!AdminHelper::isCreate()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $request->validate([
            'page_title' => 'required|alpha_spaces|max:150',
            'meta_title' => 'required|alpha_spaces|max:150',
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg,webp|max:5000|nullable',
            'status' => 'required|numeric',
        ]);

        $isdata = BlogPages::where('page_title', $request->input('page_title'))->get();
        if (!$isdata->isEmpty()) {
            return redirect()->back()->withError('Page Already Exists!');
        }

        $featured_image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = 'featured-image-' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('admin/uploads/images/blogpage/');
            $image->move($destinationPath, $name);
            $featured_image = 'admin/uploads/images/blogpage/' . $name;
        }
        BlogPages::insert([
            'page_title' => $request->input('page_title'),
            'page_slug' => $request->input('meta_title'),
            'page_content' => $request->input('content'),
            'featured_image' => $featured_image,
            'meta_title' => $request->input('meta_title'),
            'meta_keywords' => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
            'status' => $request->input('status'),
            'created_by' => AdminHelper::myId(),
            'user_ip' => $request->ip(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $return_url = (!empty($request->input('return_url')) ? $request->input('return_url') : AdminHelper::adminPath() . '/manage-cms');
        if ($request->input('submit') == 'Save') {
            return redirect($return_url)->withSuccess('Blog added successfully!');
        } else {
            return redirect()->back()->withSuccess('Blog added successfully!');
        }
    }

    function getDetail($id)
    {
        if (!AdminHelper::isRead()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $data = [];
        $data['page_title'] = 'Details Blog';
        $data['row'] = BlogPages::find($id);

        return view('admin.blog_management.detail', $data);
    }

    function getEdit($id)
    {
        if (!AdminHelper::isUpdate()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $data = [];
        $data['page_title'] = 'Edit Blog';
        $data['row'] = BlogPages::find($id);
        return view('admin.blog_management.edit', $data);
    }

    function postUpdateSave($id, Request $request)
    {
        if (!AdminHelper::isUpdate()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $request->validate([
            'page_title' => 'required|alpha_spaces|max:150',
            'meta_title' => 'required|alpha_spaces|max:150',
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:5000',
            'status' => 'required|numeric',
        ]);

        $isdata = BlogPages::where('id', '!=', $id)->where('page_title', $request->input('page_title'))->get();

        if (!$isdata->isEmpty()) {
            return redirect()->back()->withError('Page Already Exists!');
        }

        $featured_image = '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = 'featured-image-' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('admin/uploads/images/blogpage/');
            $image->move($destinationPath, $name);
            $featured_image = 'admin/uploads/images/blogpage/' . $name;
        }

        $blog = BlogPages::find($id);
        $blog->page_title = $request->input('page_title');
        $blog->page_content = $request->input('page_content');
        if (!empty($featured_image)) {
            $blog->featured_image = $featured_image;
        }
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_keywords = $request->input('meta_keywords');
        $blog->meta_description = $request->input('meta_description');
        $blog->status = $request->input('status');
        $blog->updated_by = AdminHelper::myId();
        $blog->user_ip = $request->ip();
        $blog->updated_at = date('Y-m-d H:i:s');
        $blog->save();

        $return_url = (!empty($request->input('return_url')) ? $request->input('return_url') : AdminHelper::adminPath() . '/manage-cms');
        return redirect($return_url)->withSuccess('Blog updated successfully!');
    }

    function getDelete($id)
    {
        if (!AdminHelper::isDelete()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        if (!empty($id)) {
            BlogPages::find($id)->delete();
            return redirect()->back()->withSuccess('Blog deleted successfully!');
        }
    }

    public function postActionSelected(Request $request)
    {
        if (!AdminHelper::isDelete()) {
            return redirect(AdminHelper::adminPath())->withError('Sorry you do not have privilege to access this area !');
        }
        $id_selected = $request->input('checkbox');
        $button_name = $request->input('button_name');
        $message = "No action taken";
        if (empty($id_selected)) {
            AdminHelper::redirect($_SERVER['HTTP_REFERER'], 'Please select at least one data!', 'warning');
        }

        if ($button_name == 'delete') {
            BlogPages::whereIn('id', $id_selected)->delete();

            AdminHelper::insertLog("Deleted data " . implode(',', $id_selected) . " by " . AdminHelper::myName() . " ip: " . $request->ip());

            $message = "The selected data deleted successfully !";

            return redirect()->back()->withSuccess($message);
        }

        if ($button_name == 'active') {
            BlogPages::whereIn('id', $id_selected)->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);

            AdminHelper::insertLog("Updated data " . implode(',', $id_selected) . " by " . AdminHelper::myName() . " ip: " . $request->ip());

            $message = "The selected data activated successfully !";
            return redirect()->back()->withSuccess($message);
        }

        if ($button_name == 'inactive') {
            BlogPages::whereIn('id', $id_selected)->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);

            AdminHelper::insertLog("Updated data " . implode(',', $id_selected) . " by " . AdminHelper::myName() . " ip: " . $request->ip());

            $message = "The selected data inactivated successfully !";
            return redirect()->back()->withSuccess($message);
        }

        return redirect()->back()->withError($message);
    }
}
