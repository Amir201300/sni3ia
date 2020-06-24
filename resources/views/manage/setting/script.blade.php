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

        ajax: "{{ route('setting.view') }}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'about_AR', name: 'about_AR'},
                {data: 'about_EN', name: 'about_EN'},
                {data: 'price_per_KM', name: 'price_per_KM'},
                {data: 'search_distance', name: 'search_distance'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
    });
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
          url = save_method == 'add' {{route('setting.update')}} ;

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
      url : '/manage/setting/show/' +id,
      type : 'get',
      success : function(data){

        $('#about_AR').val(data.about_AR);
        $('#about_EN').val(data.about_EN);
        $('#price_per_KM').val(data.price_per_KM);
        $('#search_distance').val(data.search_distance);
        $('#phone').val(data.phone);
        $('#email').val(data.email);
        $('#id').val(id);
        $('#loadEdit_'+id).css({'display' : 'none'});
        $('#formModel').modal();
          $.toast().reset('all');
      }
    })
  }
</script>





<script>
$('#seachForm').submit(function(e){
  e.preventDefault();
  var formData=$('#seachForm').serialize();
  table.ajax.url('/manage/setting/search?'+formData);
  table.ajax.reload();
})

</script>
