<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('shopify-app.app_name') }}</title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/@shopify/polaris@4.27.0/styles.min.css"
    />

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @yield('styles')
</head>

<body>
<div class="app-wrapper">
    <div class="app-content">
        <main role="main">
            <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:15px;">

                @include('vendor.shopify-app.include.nav', ['url' => $instagramConnect])
                @yield('content')

            </div>
        </main>
    </div>
</div>

<div id="popup_window">
    <div class="image_view" id="image_view">
        <img id="canvas" src="https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/116132202_146405763745960_4676774124660546310_n.jpg?_nc_cat=100&_nc_sid=8ae9d6&_nc_ohc=eDIoynnJvlQAX8sZVOc&_nc_ht=scontent-frx5-1.cdninstagram.com&oh=c0740e796b0e6320187c73514a91267a&oe=5F4538B4" alt="">
    </div>
    <div class="tags-container">
        <div class="tags-header">
            <div class="tags-profile">
                <div style="display: flex; align-items: center;">
                    <img src="{{$pic_user ?? ''}}" alt="">
                    <h2 id="instagram_username" class="Polaris-Heading" style="font-weight: 500;">@instagramfeed</h2>
                </div>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="position: relative; top: -1px;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.41401 8.00001L15.707 1.70701C16.098 1.31601 16.098 0.684006 15.707 0.293006C15.316 -0.0979941 14.684 -0.0979941 14.293 0.293006L8.00001 6.58601L1.70701 0.293006C1.31601 -0.0979941 0.684006 -0.0979941 0.293006 0.293006C-0.0979941 0.684006 -0.0979941 1.31601 0.293006 1.70701L6.58601 8.00001L0.293006 14.293C-0.0979941 14.684 -0.0979941 15.316 0.293006 15.707C0.488006 15.902 0.744006 16 1.00001 16C1.25601 16 1.51201 15.902 1.70701 15.707L8.00001 9.41401L14.293 15.707C14.488 15.902 14.744 16 15 16C15.256 16 15.512 15.902 15.707 15.707C16.098 15.316 16.098 14.684 15.707 14.293L9.41401 8.00001Z" fill="#212B36"/>
                </svg>


            </div>
            <div class="tags-content">
                <p>Tag products in photo and your customers can directly Shop from your gallery.</p>
            </div>


            <div class="tags-form" style="margin-bottom: 15px;">
                <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px; position: relative;">
                    <div>
                        <div role="combobox" aria-expanded="true" aria-owns="PolarisComboBox4" aria-controls="PolarisComboBox4" aria-haspopup="true" tabindex="0">
                            <div>
                                <div class="">
                                    <div class="Polaris-Connected">
                                        <div class="Polaris-Connected__Item Polaris-Connected__Item--focused Polaris-Connected__Item--primary">
                                            <div class="Polaris-TextField Polaris-TextField--focus">
                                                <div class="Polaris-TextField__Prefix" id="PolarisTextField4Prefix"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
                                              </svg></span></div><input data-shop-id="{{\Illuminate\Support\Facades\Auth::id()}}" data-type="search" id="PolarisTextField4" placeholder="Search" autocomplete="off" class="Polaris-TextField__Input" aria-labelledby="PolarisTextField4Label PolarisTextField4Prefix" aria-invalid="false" aria-autocomplete="list" aria-multiline="false" value="" tabindex="0" aria-controls="Polarispopover4" aria-owns="Polarispopover4" aria-expanded="true">
                                                <div class="Polaris-TextField__Backdrop"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-type="result-list-container" class="Polaris-PositionedOverlay Polaris-Popover__PopoverOverlay" style="top: 35px; left: 0; width: 100%;">
                        <div class="Polaris-Popover Polaris-Popover--fullWidth" data-polaris-overlay="true">
                            <div class="Polaris-Popover__FocusTracker" tabindex="0"></div>
                            <div class="Polaris-Popover__Wrapper">
                                <div id="Polarispopover4" tabindex="-1" class="Polaris-Popover__Content" style="height: 100%;">
                                    <div class="Polaris-Popover__Pane Polaris-Scrollable Polaris-Scrollable--vertical Polaris-Scrollable--hasBottomShadow Polaris-Scrollable--verticalHasScrolling" data-polaris-scrollable="true">
                                        <div id="PolarisComboBox4" role="listbox">
                                            <ul class="Polaris-OptionList" role="presentation">
                                                <li>
                                                    <ul data-type="result-list" class="Polaris-OptionList__Options" id="PolarisOptionList2-0" role="presentation">
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Polaris-Popover__FocusTracker" tabindex="0"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tags-list">
            </div>
        </div>
    </div>
</div>
<div id="overlay"></div>
<span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge" id="preloader">
        <svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
        </svg>
    </span>

<style>
    #popup_window .image_view img{
        cursor: url({{asset('/images/cursor_select.png')}});
    }
</style>

@if(config('shopify-app.appbridge_enabled'))
    <script src="https://unpkg.com/@shopify/app-bridge{{ config('shopify-app.appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>
    <script>
        var AppBridge = window['app-bridge'];
        var createApp = AppBridge.default;
        var app = createApp({
            apiKey: '{{ config('shopify-app.api_key') }}',
            shopOrigin: '{{ Auth::user()->name }}',
            forceRedirect: true,
        });
    </script>

    @include('shopify-app::partials.flash_messages')
@endif
@yield('scripts')
</body>
</html>
