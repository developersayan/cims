<?php

namespace App\Http\Controllers\ComplaintMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\complaintModeModel;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class ComplaintMasterController extends Controller
{
    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',17)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',17)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',17)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',17)->where('delete_option','Y')->first();


        
        return $next($request);
    });
  }


    public function list()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;
        $deletepermission = $this->delete_option;
        if (@$permission && @$permission->view_option=="Y") {
       $data = [];
       $data['data'] = complaintModeModel::where('isDelete',0)->get();
       if(@$addpermission->add_option=="Y")
        {
            $data['add'] = 'Y';
        }else{
            $data['add'] = 'N';
        }

        if(@$editpermission->edit_option=="Y")
        {
            $data['edit'] = 'Y';
        }else{
            $data['edit'] = 'N';
        }

        if(@$deletepermission->delete_option=="Y")
        {
            $data['delete'] = 'Y';
        }else{
            $data['delete'] = 'N';
        }
       return view('complaint_mode.list',$data);
       }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    public function add(Request $request)
    {
        $new = new complaintModeModel;
        $new->modeName = $request->modeName;
        $new->typeofAttachment = $request->typeofAttachment;
        $new->save();
        Alert::success('You\'ve Successfully Added A Complaint Mode');
        return Redirect::back();
    }

    public function delete($id)
    {
        complaintModeModel::where('complaintmodeID',$id)->update(['isDelete'=>1]);
        Alert::success('You\'ve Successfully Deleted A Complaint Mode');
        return Redirect::back();
    }

    public function update(Request $request)
    {
        complaintModeModel::where('complaintmodeID',$request->id)->update([
            'modeName'=>$request->modeName,
            'typeofAttachment'=>$request->typeofAttachment,
        ]);
        Alert::success('You\'ve Successfully Updated A Complaint Mode');
        return Redirect::back();
    }

    
}