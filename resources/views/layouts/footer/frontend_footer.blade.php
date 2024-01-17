@php
    $footer = App\Models\ProfileApp::find(1)->footer;
@endphp
<!-- footer -->
<footer class="footer text-center"><span>{{ $footer }}</span></footer>
<!-- end footer -->