<?php

namespace App\Http\Controllers\Corrupt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CorruptionType;
use Redirect;
use Alert;
use App\Models\UserToRole;
use App\Models\RolePermission;
class CorruptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){      
    $this->middleware(function ($request, $next) {      
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
        
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',21)->where('view_option','Y')->first();
        $this->add_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',21)->where('add_option','Y')->first();

        $this->edit_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',21)->where('edit_option','Y')->first();

        $this->delete_option = RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('sub_menu_id',21)->where('delete_option','Y')->first();


        
        return $next($request);
    });
  }

    public function index()
    {
        $permission = $this->view_option;
        $addpermission = $this->add_option;
        $editpermission = $this->edit_option;
        $deletepermission = $this->delete_option;
        if (@$permission && @$permission->view_option=="Y") {
        $data = [];
        $data['data'] = CorruptionType::orderBy('corruptionTypeID','desc')->where('isDelete',0)->get();

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


        return view('corruptype.list', $data);

        }else{
           Alert::error('You are not allowed to access this page');
           return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request);
         $dzonkhag = new CorruptionType();
         $dzonkhag->name = $request->name;
         $dzonkhag->remarks = $request->remarks;
         $dzonkhag->isDelete = 0;
         $dzonkhag->save();
 
         Alert::success('You\'ve Successfully Added A Corruption Type ');
         return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteCoruptype($id){
        // dd($id);
        CorruptionType::where(['corruptionTypeID' => $id])->delete();
        Alert::success(' Corruption Type Deleted Successfully');
        return redirect()->back();
    }

    public function EditCorruptype(Request $request){
        // dd($request);
        $person = new CorruptionType;
            $person->where(['corruptionTypeID' => $request->corruptionTypeID])->update([
                'name' => $request->name,
                'remarks' => $request->remarks,
            ]);

            Alert::success(' Corruption Type Updated Successfully');
            return redirect()->back();
    }
}