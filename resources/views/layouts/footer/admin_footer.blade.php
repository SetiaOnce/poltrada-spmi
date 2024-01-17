@php
    $footer = App\Models\ProfileApp::find(1)->footer;
@endphp
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                {{ $footer }}
            </div>
        </div>
    </div>
</footer>