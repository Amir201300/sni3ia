<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth;
use App\User;
use App\Models\live_service;

class Live_serviceController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.Live_service.index');
    }

    //View Function
    public function view(Request $request)
    {
        $live_service=live_service::orderBY('created_at','desc')->get();
        return $this->dataFunction($live_service);
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
            ]

        );

        $live_service=new Live_service;

        $live_service->name_ar=$request->name_ar;
        $live_service->name_en=$request->name_en;
        $live_service->desc_ar=$request->desc_ar;
        $live_service->desc_en=$request->desc_en;
        $live_service->phone=$request->phone;
        $live_service->sms=$request->sms;
        $live_service->lat=$request->lat;
        $live_service->address=$request->address;
        $live_service->lng=$request->lng;
        $live_service->whatsapp=$request->whatsapp;
        $live_service->image=saveImage('live_service',$request->image);
        $live_service->save();
        return response()->json(['errors'=>false]);

    }

    //Show Function
    public function show($id)
    {
        $live_service=live_service::find($id);
        if(is_null($live_service))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $live_service;
    }




    // update function
    public function update(Request $request)
    {
        $live_service=live_service::find($request->id);
        if(is_null($live_service))
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
            ]

        );
        $live_service->name_ar=$request->name_ar;
        $live_service->name_en=$request->name_en;
        $live_service->desc_ar=$request->desc_ar;
        $live_service->phone=$request->phone;
        $live_service->sms=$request->sms;
        $live_service->lat=$request->lat;
        $live_service->address=$request->address;
        $live_service->lng=$request->lng;
        $live_service->whatsapp=$request->whatsapp;
        if($request->image){
            deleteFile('live_service',$live_service->image);
            $live_service->image=saveImage('live_service',$request->image);
        }
        $live_service->save();

        return response()->json(['errors'=>false]);

    }


    public function delete(Request $request,$id)
    {
        if($request->type==2)
        {
            $ids=explode(',',$id);
            $Ads=live_service::whereIn('id',$ids)->delete();
        }else{
            $Ads=live_service::find($id);
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
            $image='<a href="/images/live_service/'.$data->image.'" target="_blank">'.
            '<img src="/images/live_service/'.$data->image.'" width="50" height="50"></a>';
            return $image;
        })->editColumn('rate',function($data)
        {
            $rate='('.$data->rateRelation->count().')';
            for($i=1;$i<=$data->rate;$i++ ) {
                $rate .= '<i class="fa fa-star"></i>';
            }
            return $rate;
        })->rawColumns(['action' => 'action','checkBox'=>'checkBox','status'=>'status',
            'image'=>'image','rate'=>'rate'])->make(true);

    }
}
