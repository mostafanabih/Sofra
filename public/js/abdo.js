$(document).on('click','.destroy',function () {
   var route = $(this).data('route');
   var token = $(this).data('token');
   $.confirm({
       icon : 'fa fa-warning',
       animation :'Rotate',
       closeAnimation : 'RotateX',
       theme: 'black',
       title : 'تاكيد عمليه الحذف',
       content : 'هل انت متاكد من الحذف؟',
       confirmButton : 'نعم',
       cancelButton : 'لا',
       confirmButtonClass : 'btn-info',
       cancelButtonClass : 'btn-danger',
       columnClass : 'col-md-6 col-md-offset-3',
       modalClass : "modal-danger ",
       rtl: true,
       confirm: function () {
           $.ajax({
               url: route,
               type :'post',
               data : {_method:'delete',_token :token},
               dataType:'json',
               success:function (data) {
                   if(data.status === 0)
                   {
                       Swal.fire("خطا!",data.message,"error")
                   }else{
                       $("#removable"+data.id).remove();
                       Swal.fire("أحسنت!",data.message,"success")
                   }
               }
           });
       }
   });
});
