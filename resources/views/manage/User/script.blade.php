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

        ajax: "{{ route('User.view') }}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status'},
                {data: 'type', name: 'type'},
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

        $('#title').text('{{trans("اضافة مستخدم جديد")}}');

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
          url = save_method == 'add' ? "{{route('User.store')}}" : "{{route('User.update')}}" ;

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
      url : '/manage/User/show/' +id,
      type : 'get',
      success : function(data){

        $('#username').val(data.username);
        $('#phone').val(data.phone);
        $('#email').val(data.email);
        $('#type').val(data.type);
        $('#status').val(data.status);
        $('#lat').val(data.lat);
        $('#lng').val(data.lng);
        $('#lang').val(data.lang);
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
      deleteProccess("/manage/User/delete/" +id_num);
      }else{
        
      deleteProccess("/manage/User/delete/"+checkArray +'?type=2');

    }
      }

    
    
</script>



<script>
$('#seachForm').submit(function(e){
  e.preventDefault();
  var formData=$('#seachForm').serialize();
  table.ajax.url('/manage/User/search?'+formData);
  table.ajax.reload();
})

</script>
