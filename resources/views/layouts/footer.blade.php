<p class="text-center"><small>Built with <a href="https://www.laravel.com" target="_blank">Laravel</a> and <a href="http://php.net" target="_blank">PHP</a>. Uses <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a> and <a href="http://glyphicons.com/" target="_blank">Glyphicons</a></small></p>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"
    integrity="sha256-JklDYODbg0X+8sPiKkcFURb5z7RvlNMIaE3RA2z97vw="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>

{{-- Only load the Slick and jQuery-File-Uploadjavascript if the machine detail page is being shown
    Slick image carousel http://kenwheeler.github.io/slick/ --}}
@if (Route::currentRouteName() == 'machines.show')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/slick_cfg.js') }}"></script>
    <!-- blueimp jQuery-File-Upload https://github.com/blueimp/jQuery-File-Upload -->
    <script src="{{ asset('js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-image.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-main.js')}}"></script>
@endif
