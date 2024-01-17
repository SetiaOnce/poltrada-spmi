<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    
// ajax mengambil data produk
// $(document).ready(function(){
//   $('select[name="sub_jenis_produk_id"]').on('change',function(){
//     var data_id = $(this).val();
//     if (data_id) {
//       $('#data-produk-spmi'+data_id+'').html('');
//       var url = '{{ route("ajax.get.produk", ":data_id") }}';
//       url = url.replace(':data_id', data_id);
//       $('#table-produk'+data_id+'').hide()
//       $.ajax({
//         url: url,
//         type:"GET",
//         dataType:"json",
//         success:function(response) {
//           console.log(response.data);
//           $('#table-produk'+data_id+'').show();
//           $.each(response.data, function(key,value){
//             var $key = key + 1;

//             $('#data-produk-spmi'+data_id+'').append('<tr><td class="text-center">'+$key+'</td>\
//               <td>'+value.nama_produk+'</td>\
//               <td align="center">\
//               <a href="{{ asset("") }}'+value.file_pdf+'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Lihat Pdf" target="_blank">\
//               LIHAT PDF\
//               </a>\
//               </td>\
//               </tr>');
//             });
//           },
//     });

//     }else{
//       Swal.fire({
//         icon:'warning',
//         title: 'Data Tidak Ditemukan...',
//         html: 'Silakan coba lagi !'
//       });
//     }

//   });
// });
</script>