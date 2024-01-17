<script type="text/javascript">
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    
  function _peraturan(jenis_peraturan_id) {
    var url = '{{ route("frontend.get.peraturan", ":jenis_peraturan_id") }}';
    url = url.replace(':jenis_peraturan_id', jenis_peraturan_id);
    //datatable
    var table = $('#dt-peraturan-'+jenis_peraturan_id+'').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'nama_peraturan', name: 'nama_peraturan'},
        {data: 'btn', name: 'btn', orderable: false, searchable: false},
        ]
    });
  }
</script>