// $(function(){
//      $(document).on('click','#delete',function(e){
//          e.preventDefault();
//          var link = $(this).attr("href"); 
//           Swal.fire({
//             title: 'Apakah Kamu Yakin?',
//             text: "Menghapus data ini?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Hapus!'
//           }).then((result) => {
//             if (result.isConfirmed) {
//               window.location.href = link
//             }
//           }) 
//      });
 
//    });

   
$(function(){
     $(document).on('click','#deletePesan',function(e){
         e.preventDefault();
         var link = $(this).attr("href"); 
          Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Menghapus semua pesan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = link
            }
          }) 
     });
 
   });

   $(function(){
    $(document).on('click','#deletedetail',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Hapus Pesan ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Hapus!'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });

  $(function(){
    $(document).on('click','#list',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Tandai Semua?',
           text: "Tandai semua pesan sudah terbaca",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Tandai!'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });

  $(function(){
    $(document).on('click','#logout',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "ingin melakukan logout",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Log out!',
           cancelButtonText: "Batal",
         }).then((result) => {
           if (result.isConfirmed) {
            // onclick="event.preventDefault();
            this.closest('form').submit();
           }
         }) 
    });

  });

  $(function(){
    $(document).on('click','#terima',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "ingin menirima partisipan ini ini",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Terima!'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });


  $(function(){
    $(document).on('click','#publish',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "ingin publish responden ini",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Publish !'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });

  $(function(){
    $(document).on('click','#unpublish',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "ingin unpublish responden ini",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Unpublish !'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });

  $(function(){
    $(document).on('click','#ajukan',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "ingin mengajukan data ini",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Ajukan !'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });

  $(function(){
    $(document).on('click','#unpublish',function(e){
        e.preventDefault();
        var link = $(this).attr("href"); 
         Swal.fire({
           title: 'Apakah anda yakin?',
           text: "ingin unpublish responden ini",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Unpublish !'
         }).then((result) => {
           if (result.isConfirmed) {
             window.location.href = link
           }
         }) 
    });

  });
