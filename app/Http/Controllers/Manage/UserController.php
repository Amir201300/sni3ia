<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth,Hash;
use App\User;

class UserController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.User.index');
    }

    //View Function
    public function view(Request $request)
    {
        $User=User::orderBY('created_at','desc')->get();
        return $this->dataFunction($User);
    }

    //Store Function

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [

                'username'=>'required',
                'phone'=>'required|unique:users',
                'email'=>'required|unique:users',
                'password'=>'required',
                'status'=>'required',
                'type'=>'required',
                'lat'=>'required',
                'lng'=>'required',
            ]


        );

        $User=new User;

        $User->username=$request->username;
        $User->status=$request->status;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->type=$request->type;
        $User->password=Hash::make($request->password);
        $User->lat=$request->lat;
        $User->lng=$request->lng;
        $User->lang=$request->lang;
        $User->save();
        return response()->json(['errors'=>false]);

    }

    //Show Function
    public function show($id)
    {
        $User=User::find($id);
        if(is_null($User))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $User;
    }




    // update function
    public function update(Request $request)
    {
        $User=User::find($request->id);
        if(is_null($User))
        {
            return 5;
        }
        $this->validate(
            $request,
            [

                'username'=>'required',
                'phone'=>'required',
                'email'=>'required|unique:users,email,'.$request->id,
                'status'=>'required',
                'type'=>'required',
                'lat'=>'required',
                'lng'=>'required',
            ],
            [
                'username.required'=>'برجاء ادخال اسم المستخدم'
            ]

        );
        $User->username=$request->username;
        $User->status=$request->status;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->type=$request->type;
        if($request->password)
            $User->password=Hash::make($request->password);
        $User->lat=$request->lat;
        $User->lng=$request->lng;
        $User->lang=$request->lang;
        $User->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=User::whereIn('id',$ids)->delete();
        }else{
            $Ads=User::find($id);
            if(is_null($Ads))
            {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors'=>false]);

    }

    public function getImage($id)
    {
        $type=2;
        $array=Ads::find($id);
        return view('manage.Images.index',compact('array','type'));
    }



    private function dataFunction($data)
    {
        return Datatables::of($data)->addColumn('action' ,function($data){
            $options='<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="edit('.$data->id.')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_'.$data->id.'" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options.='<button type="button" onclick="deleteFunction('.$data->id.',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox',function ($data){
            $checkBox='<td class="sorting_1">'.
                '<div class="custom-control custom-checkbox">'.
                '<input type="checkbox" class="mybox" id="checkBox_'.$data->id.'" onclick="check('.$data->id.')">'.
                '</div></td>';
            return $checkBox;
        })->editColumn('status',function($data){
            $status='<button class="btn waves-effect waves-light btn-rounded btn-success statusBut">'.trans('main.Active').'</button>';
            if($data->status == 0)
                $status='<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut">'.trans('main.inActive').'</button>';
            return $status;
        })->editColumn('type',function($data){
            $type='<button class="btn waves-effect waves-light btn-rounded btn-success statusBut">مستخدم عادي</button>';
            if($data->type == 'winch')
                $type='<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut">ونش</button>';
            return $type;

        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status','type'=>'type'])->make(true);

    }
}
