<?php

namespace App\Http\Controllers\Manage;

use App\Models\Car_electration;
use App\Models\Car_model;
use App\Models\Province;
use App\Models\Workshop_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\User;
use App\Models\homeService;

class homeServiceController extends Controller
{

    //index
    public function index(Request $request)
    {
        $car_electration = Car_electration::all();
        return view('manage.homeService.index', compact('car_electration'));
    }

    //View Function
    public function view(Request $request)
    {
        $car_electration=homeService::orderBY('created_at','desc')->get();
        return $this->dataFunction($car_electration);
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
                'car_electration_id'=>'required',
            ]

        );

        $homeService=new homeService;

        $homeService->name_ar=$request->name_ar;
        $homeService->name_en=$request->name_en;
        $homeService->desc_ar=$request->desc_ar;
        $homeService->desc_en=$request->desc_en;
        $homeService->phone=$request->phone;
        $homeService->sms=$request->sms;
        $homeService->whatsapp=$request->whatsapp;
        $homeService->image=saveImage('homeService',$request->image);
        $homeService->car_electration_id=$request->car_electration_id;
        $homeService->save();
        return response()->json(['errors'=>false]);

    }

    //Show Function
    public function show($id)
    {
        $homeService=homeService::find($id);
        if(is_null($homeService))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $homeService;
    }




    // update function
    public function update(Request $request)
    {
        $homeService=homeService::find($request->id);
        if(is_null($homeService))
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
                'car_electration_id'=>'required',
            ]

        );
        $homeService->name_ar=$request->name_ar;
        $homeService->name_en=$request->name_en;
        $homeService->desc_ar=$request->desc_ar;
        $homeService->phone=$request->phone;
        $homeService->sms=$request->sms;
        $homeService->whatsapp=$request->whatsapp;
        $homeService->car_electration_id=$request->car_electration_id;
        if($request->image){
            deleteFile('homeService',$homeService->image);
            $homeService->image=saveImage('homeService',$request->image);
        }
        $homeService->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=homeService::whereIn('id',$ids)->delete();
        }else{
            $Ads=homeService::find($id);
            if(is_null($Ads))
            {
                return 5;
            }
            deleteFile('homeService',$Ads->image);
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
            $image='<a href="/images/homeService/'.$data->image.'" target="_blank">'.
                '<img src="/images/homeService/'.$data->image.'" width="50" height="50"></a>';
            return $image;
        })->editColumn('rate',function($data)
        {
            $rate='('.$data->rateRelation->count().')';
            for($i=1;$i<=$data->rate;$i++ ) {
                $rate .= '<i class="fa fa-star"></i>';
            }
            return $rate;
        })->editColumn('car_electration_id',function($data) {
            $car_electration_id = $data->car_electration->name_ar;

            return $car_electration_id;

        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status',
            'image'=>'image','rate'=>'rate','car_model_id'=>'car_model_id','province_id'=>'province_id','workShop_id'=>'workShop_id','car_electration_id'=>'car_electration_id'])->make(true);

    }
}
