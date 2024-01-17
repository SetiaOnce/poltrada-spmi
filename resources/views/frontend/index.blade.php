@extends('layouts.frontend')
@section('konten')

@section('title')
Satuan Penjaminan Mutu
@stop

@section('css')

@stop

<!-- Banner -->
@include('frontend.konten.banner')
<!-- End Banner -->

<div class="container-fluid">
    
    @include('frontend.konten.status_akreditasi')

    @include('frontend.konten.kegiatan')

    @include('frontend.konten.survey')
    
    @include('frontend.konten.link_survey')

    @include('frontend.konten.providers')
    
</div>

@include('layouts.footer.frontend_footer')

@section('js')
<script>
    $('#datatable').DataTable({});
</script>
@stop
@endsection