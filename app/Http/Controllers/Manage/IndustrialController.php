<?php

namespace App\Http\Controllers\Manage;

use App\Models\Car_model;
use App\Models\Province;
use App\Models\Workshop_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\User;
use App\Models\Industrial;

class IndustrialController extends Controller
{

    //index
    public function index(Request $request)
    {
        $car = Car_model::all();
        $workShop = Workshop_type::all();
        $province = Province::all();

        return view('manage.Industrial.index', compact('car','workShop','province'));
    }

    //View Function
    public function view(Request $request)
    {
        $Industrial=Industrial::orderBY('created_at','desc')->get();
        return $this->dataFunction($Industrial);
    }

    //Store Function

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [

                'name_en' => 'required',
                'name_ar'=>'required',
                'image'=>'required',
                'sms'=>'required',
                'whatsapp'=>'required',
                'car_model_id'=>'required',
                'workShop_id'=>'required',
                'province_id'=>'required',
            ]

        );

        $Industrial=new Industrial;

        $Industrial->name_ar=$request->name_ar;
        $Industrial->name_en=$request->name_en;
        $Industrial->desc_ar=$request->desc_ar;
        $Industrial->desc_en=$request->desc_en;
        $Industrial->phone=$request->phone;
        $Industrial->sms=$request->sms;
        $Industrial->whatsapp=$request->whatsapp;
        $Industrial->image=saveImage('Industrial',$request->image);
        $Industrial->car_model_id=$request->car_model_id;
        $Industrial->workShop_id=$request->workShop_id;
        $Industrial->province_id=$request->province_id;
        $Industrial->save();
        return response()->json(['errors'=>false]);

    }

    //Show Function
    public function show($id)
    {
        $Industrial=Industrial::find($id);
        if(is_null($Industrial))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $Industrial;
    }




    // update function
    public function update(Request $request)
    {
        $Industrial=Industrial::find($request->id);
        if(is_null($Industrial))
        {
            return 5;
        }
        $this->validate(
            $request,
            [

                'name_en' => 'required',
                'name_ar'=>'required',
                'sms'=>'required',
                'whatsapp'=>'required',
                'car_model_id'=>'required',
                'workShop_id'=>'required',
                'province_id'=>'required',
            ]

        );
        $Industrial->name_ar=$request->name_ar;
        $Industrial->name_en=$request->name_en;
        $Industrial->desc_ar=$request->desc_ar;
        $Industrial->phone=$request->phone;
        $Industrial->sms=$request->sms;
        $Industrial->whatsapp=$request->whatsapp;
        $Industrial->car_model_id=$request->car_model_id;
        $Industrial->workShop_id=$request->workShop_id;
        $Industrial->province_id=$request->province_id;
        if($request->image){
            deleteFile('live_service',$Industrial->image);
            $Industrial->image=saveImage('Industrial',$request->image);
        }
        $Industrial->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=Industrial::whereIn('id',$ids)->delete();
        }else{
            $Ads=Industrial::find($id);
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
        })->editColumn('image',function($data){
            $image='<a href="/images/Industrial/'.$data->image.'" target="_blank">'.
                '<img src="/images/Industrial/'.$data->image.'" width="50" height="50"></a>';
            return $image;
        })->editColumn('rate',function($data)
        {
            $rate='('.$data->rateRelation->count().')';
            for($i=1;$i<=$data->rate;$i++ ) {
                $rate .= '<i class="fa fa-star"></i>';
            }
            return $rate;
        })->editColumn('car_model_id',function($data){
            $car_model_id=$data->car_models->name_ar;
            return $car_model_id;
        })->editColumn('workShop_id',function($data){
            $workShop_id=$data->work_shop->name_ar;
            return $workShop_id;
        })->editColumn('province_id',function($data){
            $province_id=$data->province->name_ar;
            return $province_id;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status',
            'image'=>'image','rate'=>'rate','car_model_id'=>'car_model_id','province_id'=>'province_id','workShop_id'=>'workShop_id'])->make(true);

    }
}
