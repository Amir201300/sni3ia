<div class="modal fade bd-example-modal-lg" id="formModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formSubmit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="title"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الاسم بالعربيه </label>
                                <input type="text" id="name_ar" name="name_ar" required class="form-control"   >
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الاسم بالانجليزيه</label>
                                <input type="text" id="name_en" name="name_en" required class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الوصف بالعربيه</label>
                                <input type="text" id="desc_ar" name="desc_ar"  class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الوصف بالانجليزيه</label>
                                <input type="text" id="desc_en" name="desc_en"  class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الصوره</label>
                                <input type="file" id="image" name="image"  class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">رقم الهاتف</label>
                                <input type="text" id="phone" name="phone"  class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">رقم الرسائل</label>
                                <input type="text" id="sms" name="sms" required class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">رقم واتساب</label>
                                <input type="text" id="whatsapp" name="whatsapp" required class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">نوع السياره</label>
                                <select  id="car_model_id" name="car_model_id"  class="form-control"   >
                                    @foreach($car as $car_model_id)
                                    <option value="{{$car_model_id->id}}">{{$car_model_id->name_ar}}</option>
                                        @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">الورشه المتاحه</label>
                                <select  id="workShop_id" name="workShop_id"  class="form-control"   >
                                    @foreach($workShop as $workShop_id)
                                        <option value="{{$workShop_id->id}}" >{{$workShop_id->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">المقاطعه</label>
                                <select  id="province_id" name="province_id"  class="form-control"   >
                                    @foreach($province as $province_id	)
                                        <option value="{{$province_id->id}}">{{$province_id->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الحالة</label>
                                <select  id="status" name="status" required class="form-control"   >
                                    <option value="1"> مفعل</option>
                                    <option value="0"> غير مفعل</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="err"></div>
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">{{trans('main.close')}}</button>
                    <button type="submit" id="save" class="btn btn-success"><i class="ti-save"></i> {{trans('main.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>



























<div class="modal fade bd-example-modal-lg" id="FacilityModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="faSubmit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="title"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="fa">


                    </div>
                </div>
                <div id="err"></div>
                <input type="hidden" name="shop_id" id="shop_id2">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('main.close')}}</button>
                    <button type="submit" class="btn btn-success"><i class="ti-save"></i> {{trans('main.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
