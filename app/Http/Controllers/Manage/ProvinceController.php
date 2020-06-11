<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\User;
use App\Models\Province;

class ProvinceController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.Province.index');
    }

   //View Function
        public function view(Request $request)
    {
        $car_model=Province::orderBY('created_at','desc')->get();
        return $this->dataFunction($car_model);
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

        $car_model=new Province;

        $car_model->name_ar=$request->name_ar;
        $car_model->status=$request->status;
        $car_model->name_en=$request->name_en;
        $car_model->save();
        return response()->json(['errors'=>false]);

    }

    //Show Function
    public function show($id)
    {
        $car_model=Province::find($id);
        if(is_null($car_model))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $car_model;
    }




    // update function
    public function update(Request $request)
    {
        $car_model=Province::find($request->id);
        if(is_null($car_model))
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
        $car_model->name_ar=$request->name_ar;
        $car_model->status=$request->status;
        $car_model->name_en=$request->name_en;
        $car_model->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=Province::whereIn('id',$ids)->delete();
        }else{
            $Ads=Province::find($id);
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
