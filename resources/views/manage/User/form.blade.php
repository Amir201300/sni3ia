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
                                            <label for="example-email">اسم المستخدم </label>
                                            <input type="text" id="username" name="username" required class="form-control"   >
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">رقم الهاتف</label>
                                            <input type="text" id="phone" name="phone"  required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">الايميل</label>
                                            <input type="email" id="email" name="email" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">الرقم السري</label>
                                            <input type="password" id="password" name="password" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">حالة التفعيل</label>
                                            <select  id="status" name="status" required class="form-control"   >
                                                <option value="1"> مفعل</option>
                                                <option value="0"> غير مفعل</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">نوع المستخدم</label>
                                            <select  id="type" name="type" required class="form-control"   >
                                                <option value="user"> مستخدم عادي</option>
                                                <option value="winch">ونش</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">خط الطول</label>
                                            <input type="text" id="lat" name="lat" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">خط العرض</label>
                                            <input type="text" id="lng" name="lng" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-email">لغه المستخدم</label>
                                            <select  id="lang" name="lang"  class="form-control"   >
                                                <option value="en"> الانجليزيه</option>
                                                <option value="ar">العربيه</option>
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
