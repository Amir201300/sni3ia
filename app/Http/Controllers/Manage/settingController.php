<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator,Auth,Hash;
use App\Models\setting;
class settingController extends Controller
{

    //index
    public function index(Request $request)
    {
        return view('manage.setting.index');
    }

    //View Function
    public function view(Request $request)
    {
        $setting=setting::orderBY('created_at','desc')->get();
        return $this->dataFunction($setting);
    }



    //Show Function
    public function show($id)
    {
        $setting=setting::find($id);
        if(is_null($setting))
        {
            return BaseController::Error('Product not exist','الكلمة الدلالية غير موجودة');
        }

        return $setting;
    }




    // update function
    public function update(Request $request)
    {
        $setting=setting::find($request->id);
        if(is_null($setting))
        {
            return 5;
        }
        $this->validate(
            $request,
            [


            ]

        );
        $setting->about_AR=$request->about_AR;
        $setting->about_EN=$request->about_EN;
        $setting->price_per_KM=$request->price_per_KM;
        $setting->search_distance=$request->search_distance;
        $setting->phone=$request->phone;
        $setting->email=$request->email;
        $setting->save();

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
            return $options;
        })->addColumn('checkBox',function ($data){
            $checkBox='<td class="sorting_1">'.
                '<div class="custom-control custom-checkbox">'.
                '<input type="checkbox" class="mybox" id="checkBox_'.$data->id.'" onclick="check('.$data->id.')">'.
                '</div></td>';
            return $checkBox;


        })->rawColumns(['action' => 'action','checkBox'=>'checkBox',])->make(true);

    }
}
