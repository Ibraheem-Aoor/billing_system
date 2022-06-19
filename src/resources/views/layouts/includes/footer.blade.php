<footer>
    @guest()
        <script>
            window.localStorage.removeItem('permissions');
        </script>
    @endguest

    @auth()
        <script>
            window.localStorage.setItem('permissions', JSON.stringify(
                <?php echo json_encode(array_merge(
                        resolve(\App\Repositories\Core\Auth\UserRepository::class)->getPermissionsForFrontEnd(),
                        [
                            'is_app_admin' => auth()->user()->isAppAdmin(),
                        ]
                    )
                )
                ?>
            ))
        </script>
    @endauth

    <script>
        window.settings = <?php echo json_encode($settings) ?>
    </script>

    @stack('before-scripts')
    <script>
      $(".horizontal-menu .nav li:last").hide();

        window.localStorage.setItem('app-language', '<?php echo app()->getLocale() ?? "en"; ?>');

        window.localStorage.setItem('app-languages',
            JSON.stringify(
                <?php echo json_encode(include resource_path() . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . (app()->getLocale() ?? 'en') . DIRECTORY_SEPARATOR . 'default.php')?>
            )
        );

        window.appLanguage = window.localStorage.getItem('app-language');

        window.localStorage.setItem('base_url', '{!! request()->root() !!}');

        
    </script>
    {!! script('https://checkout.stripe.com/checkout.js') !!}
    {!! script('https://www.paypalobjects.com/api/checkout.js') !!}
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/core.js')) !!}
    {!! script('vendor/summernote/summernote-bs4.js') !!}



    @stack('after-scripts')
</footer>
