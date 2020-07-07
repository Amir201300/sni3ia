{{-- DataTable Function --}}
<script>
    var table = $('#datatable').DataTable({

        bLengthChange: false,

        searching: true,

        responsive: true,

        'processing': true,

        serverSide: true,

        order: [[0, 'desc']],

        buttons: ['copy', 'excel', 'pdf'],

        ajax: "{{ route('Live_service.view') }}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'name_ar', name: 'name_ar'},
                {data: 'name_en', name: 'name_en'},
                {data: 'rate', name: 'rate'},
                {data: 'whatsapp', name: 'whatsapp'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
    });
</script>

{{--Add Function --}}

<script>
    function addFunction()
    {
        save_method='add';

        $('#err').slideUp(200);

        $('#save').text('حفظ');

        $('#title').text('{{trans("اضافة خدمه جديد")}}');

        $('#formSubmit')[0].reset();

        $('#formModel').modal();
    }
</script>

{{--submit Function --}}

<script>
          $('#formSubmit').submit(function(e){
            e.preventDefault();
            $("#save").attr("disabled", true);
            $('#err').slideUp(200);
              TosetV2('{{ trans("main.proccess") }}','info','',false);
             var id=$('#id').val();
          var formData = new FormData($('#formSubmit')[0]);
          url = save_method == 'add' ? "{{route('Live_service.store')}}" : "{{route('Live_service.update')}}" ;

          $.ajax({
          url : url,
          type : "post",
          data : formData,
          contentType:false,
          processData:false,

          success : function(data)
          {
              $.toast().reset('all');
              $("#save").attr("disabled", false);

             if(data.errors==false)
             {
                $('#formSubmit')[0].reset();
                $('#err').slideUp(200);

                Toset('{{trans("main.success")}}','success','{{trans("main.successText")}}');

               $("#formModel").modal('toggle');
               table.ajax.reload();
               
             }
             // Error
             else
             {
              Toset('{{ trans("main.error") }}','error','',5000);

             }
          },
          error :  function(y)
          {
            $("#save").attr("disabled", false);
            Toset('{{ trans("main.tryAgin") }}','error','');
            var error = y.responseText;
            error= JSON.parse(error);
            error = error.errors;
              $.toast().reset('all');
            console.log(error );
            $('#err').empty();
            for(var i in error)
            {
              for(var k in error[i])
              {
                var message=error[i][k];
                $('#err').append("<p class='text-danger'>*"+message+"</p>");
                }
                $('#err').slideDown(200);
            }
          }
          });

        })

</script>

{

{{--Eedit --}}
<script>
  function edit(id)
  {
      TosetV2('{{ trans("main.proccess") }}','info','',false);
      $('#loadEdit_'+id).css({'display' : ''});
        save_method='edit';
        $('#save').text('تعديل');
        $('#title').text('تعديل');

    $.ajax({
      url : '/manage/live_service/show/' +id,
      type : 'get',
      success : function(data){

        $('#name_ar').val(data.name_ar);
        $('#name_en').val(data.name_en);
        $('#desc_ar').val(data.desc_ar);
        $('#desc_en').val(data.desc_en);
        $('#phone').val(data.phone);
        $('#sms').val(data.sms);
        $('#lat').val(data.lat);
        $('#lng').val(data.lng);
        $('#whatsapp').val(data.whatsapp);
        $('#status').val(data.status);
        $('#rate').val(data.rate);
        $('#id').val(id);
        $('#loadEdit_'+id).css({'display' : 'none'});
        $('#formModel').modal();
          $.toast().reset('all');
      }
    })
  }
</script>


{{--Delete --}}
<script>
    var id_num='';
    var checkNum='';
    function deleteFunction(id,check){
      
      id_num=id;
      checkNum=check;
      
      if(check == 2){
        if(checkArray.length == 0){
          alert("{{trans('main.noItemSelected')}}")
          }else{
            $('#DeleteModel').modal();
          }
        }
      
      else{
        $('#DeleteModel').modal();
      }
      
    }

    function yesDelete()
    {
      
      if(checkNum == 1){
      deleteProccess("/manage/live_service/delete/" +id_num);
      }else{
        
      deleteProccess("/manage/live_service/delete/"+checkArray +'?type=2');

    }
      }

    
    
</script>



<script>
$('#seachForm').submit(function(e){
  e.preventDefault();
  var formData=$('#seachForm').serialize();
  table.ajax.url('/manage/live_service/search?'+formData);
  table.ajax.reload();
})

</script>
