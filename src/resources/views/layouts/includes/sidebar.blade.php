<app-sidebar :data="{{ json_encode($data) }}" :logo="{{ json_encode(config('settings.application.company_logo')) }}"
    :logo-icon="{{ json_encode(config('settings.application.company_icon')) }}">
    <script>
        $(".horizontal-menu .nav li:last").hide();
    </script>
</app-sidebar>
