<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\User;
use App\Models\Car_electration;

class Car_electrationController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.Car_electration.index');
    }

   //View Function
        public function view(Request $request)
    {
        $Car_electration=Car_electration::orderBY('created_at','desc')->get();
        return $this->dataFunction($Car_electration);
    }

    //Store Function

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [

                'name_en' => 'required',
                'name_ar'=>'required',
            ]

        );

        $Car_electration=new Car_electration;

        $Car_electration->name_ar=$request->name_ar;
        $Car_electration->status=$request->status;
        $Car_electration->name_en=$request->name_en;
        $Car_electration->save();
        return response()->json(['errors'=>false]);

    }

    //Show Function
    public function show($id)
    {
        $Car_electration=Car_electration::find($id);
        if(is_null($Car_electration))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $Car_electration;
    }




    // update function
    public function update(Request $request)
    {
        $Car_electration=Car_electration::find($request->id);
        if(is_null($Car_electration))
        {
            return 5;
        }
        $this->validate(
            $request,
            [

                'name_en' => 'required',
                'name_ar'=>'required',
            ]

        );
        $Car_electration->name_ar=$request->name_ar;
        $Car_electration->status=$request->status;
        $Car_electration->name_en=$request->name_en;
        $Car_electration->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=Car_electration::whereIn('id',$ids)->delete();
        }else{
            $Ads=Car_electration::find($id);
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
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status'])->make(true);

    }
}
