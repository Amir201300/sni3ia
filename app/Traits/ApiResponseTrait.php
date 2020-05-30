<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * @param null $data
     * @param null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiResponseData($data = null, $message = null, $code = 200)
    {

        return response()->json(['status'=>1, 'data'=>$data,'message'=>$message],200);
    }

    /**
     * @param $status
     * @param null $message
     * @param int $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function apiResponseMessage( $status,$message = null,$code = 200)
    {
        $array = [
            'status' =>  $status,
            'message' => $message,
            'data'=>null,
        ];
        return response($array, 200);
    }

    /**
     * @param $array
     * @param $arabic
     * @param $english
     * @param $lang
     * @return \Illuminate\Http\JsonResponse
     */
    public function not_found($array,$arabic,$english,$lang){
        if(is_null($array)){
            $msg=$lang=='ar' ? $arabic . ' غير موجود' : $english .' not found';
            return response()->json(['status'=>0,'message'=>$msg,'data'=>null],200);
        }
    }

    /**
     * @param $lang
     * @return \Illuminate\Http\JsonResponse
     */
    public function not_found_v2($lang){
        $msg=$lang=='en' ? 'data not found' : 'الداتا غير موجودة';
        return response()->json(['status'=>0,'message'=>$msg,'data'=>null],200);
    }

    /**
     * @param string $lang
     * @param int $type
     * @return string
     */
    public function Message($lang,int $type)
    {
        if($type==1) {
            $msg = $lang == 'en' ? 'added successfully' : 'تمت الاضافة بنجاح';
        }elseif($type==2){
            $msg=$lang=='en' ? 'edited successfully' :'تم التعديل بنجاح'  ;

        }elseif ($type==3)
        {
            $msg = $lang == 'en' ? 'success' : 'تمت العملية بنجاح';
        }elseif($type==4)
        {
            $msg=$lang=='en' ? 'deleted successfully' :'تم الحذف بنجاح'  ;
        }
        return $msg;
    }

}
