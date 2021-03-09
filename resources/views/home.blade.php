@extends('shopify-app::layouts.default')

@section('content')
    <div
        style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:15px;">
        <div class="Polaris-Layout" style="padding: 10px 15px; @if (isset($error)) justify-content: flex-start; @endif ">

            @if ( isset($posts) && !empty($posts))
                <div class="Polaris-Layout__Section">

                    <div class="header-content">
                        <p class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Instagram</p>
                        <span class="Polaris-TextStyle--variationSubdued">Click on picture to start tagging products</span>
                    </div>
                    @if(isset($posts))
                        <div class="posts-images">
                            @foreach($posts->sortDesc() as $post)
                                <div class="image-post" style="background: url('{{$post->post_media_url}}'); background-size: cover; ">

                            <span class="Polaris-Badge Polaris-Badge--statusSuccess Publish-badge" data-item-bage="{{$post->id}}" @if($post->publish_status == 1) style="display: block;" @endif>
                                <span class="Polaris-VisuallyHidden">Success</span>Published
                            </span>

                                    <div class="hover_item">

                                        <button style="width: 55%; margin-bottom: 10px;" data-img="{{$post->id}}" type="button" class="Pola-action__button Polaris-Button @if($post->publish_status == 0) Polaris-Button--primary @endif publish_button @if($post->publish_status == 1) unpublish @endif" aria-expanded="false" aria-pressed="false" role="alert" aria-busy="true">
                                    <span class="Polaris-Button__Content">
                                        <span class="Polaris-Button__Spinner">
                                            <span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall">
                                                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path>
                                                </svg>
                                            </span>
                                            <span role="status">
                                                <span class="Polaris-VisuallyHidden">Loading</span>
                                            </span>
                                        </span>
                                        <span class="Polaris-Button__Text">Publish</span>
                                        <span class="Polaris-Button__Text__Unpublish">Unpublish</span>
                                    </span>
                                        </button>
                                        <button @if(isset($shop)) @if($shop->planId != 2) disabled @endif @endif type="button" class="Polaris-Button set_tag_button @if(isset($shop)) @if($shop->planId != 2) Polaris-Button--disabled @endif @endif" style="width: 55%;" data-img="{{$post->id}}" data-update-img="{{$post->id}}">
                                    <span class="Polaris-Button__Content">
                                        <span class="Polaris-Button__Text">Tag products @if($post->count_dots != 0) ({{$post->count_dots}}) @endif</span>
                                    </span>
                                        </button>



                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="Polaris-Layout__Section Polaris-Layout__Section--secondary">
                    @if ($status)
                    <div class="Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage"
                         tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner4Heading"
                         aria-describedby="Banner4Content">
                        <div class="Polaris-Banner__Ribbon">
                        <span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
                            </svg>
                        </span>
                        </div>

                            <div class="Polaris-Banner__ContentWrapper">
                                <div class="Polaris-Banner__Heading" id="Banner4Heading">
                                    <p class="Polaris-Heading">Account Connected</p>
                                </div>
                                <div class="Polaris-Banner__Content" id="Banner4Content">
                                    <p>Wrong account?
                                        <a class="Polaris-Link" href="https://help.shopify.com/manual/orders/fulfill-orders" data-polaris-unstyled="true">Read here</a>
                                    </p>
                                </div>
                            </div>

                    </div>
                    @else
                        <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                            <div class="Polaris-Banner Polaris-Banner--statusCritical Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner6Heading" aria-describedby="Banner6Content">
                                <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorRedDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                        <path d="M2 10c0-1.846.635-3.543 1.688-4.897l11.209 11.209A7.954 7.954 0 0 1 10 18c-4.411 0-8-3.589-8-8m14.312 4.897L5.103 3.688A7.954 7.954 0 0 1 10 2c4.411 0 8 3.589 8 8a7.952 7.952 0 0 1-1.688 4.897M0 10c0 5.514 4.486 10 10 10s10-4.486 10-10S15.514 0 10 0 0 4.486 0 10"></path>
                      </svg></span></div>
                                <div class="Polaris-Banner__ContentWrapper">
                                    <div class="Polaris-Banner__Heading" id="Banner6Heading">
                                        <p class="Polaris-Heading">Connection error</p>
                                    </div>
                                    <div class="Polaris-Banner__Content" id="Banner6Content">
                                        <p>Error validating access token: <b>The user has not authorized application {{config('app.instagram_client_id')}}</b> Wrong account? <a href="#" class="Polaris-Link" data-polaris-unstyled="true">Read here</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($shop))
                        @if($shop->planId != 2)
                            <div class="upgrade-link" style="display: flex; align-items: center; padding: 10px 5px;">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.22029 8.05133L10.1101 0.167272L16 7.95858L13.542 8.00495C12.7072 14.8223 5.0087 18.0687 1.23226e-07 14.5905C4.49855 14.5441 8.06957 13.5702 7.18841 8.09771L4.22029 8.05133Z" fill="#007ACE"></path>
                                </svg>
                                <p><a href="{{ route('billing', ['plan' => 2]) }}" style="
                                color: #007ACE;
                                text-decoration: none;">Upgrade your Plan</a> use more features of Instagram Service Tools.</p>
                            </div>
                            @if (isset($shop->availableViews))
                                <div class="visits-left" style="display: flex; align-items: center; padding: 5px 5px;">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512; margin-right: 10px; width: 16px; height: 16px; fill: rgb(0, 122, 206);">
                                    <g>
                                        <g>
                                            <path d="M508.177,245.995C503.607,240.897,393.682,121,256,121S8.394,240.897,3.823,245.995c-5.098,5.698-5.098,14.312,0,20.01
                                                C8.394,271.103,118.32,391,256,391s247.606-119.897,252.177-124.995C513.274,260.307,513.274,251.693,508.177,245.995z M256,361
                                                c-57.891,0-105-47.109-105-105s47.109-105,105-105s105,47.109,105,105S313.891,361,256,361z"/>
                                        </g>
                                    </g>
                                        <g>
                                            <g><path d="M271,226c0-15.09,7.491-28.365,18.887-36.53C279.661,184.235,268.255,181,256,181c-41.353,0-75,33.647-75,75c0,41.353,33.647,75,75,75c37.024,0,67.668-27.034,73.722-62.358C299.516,278.367,271,255.522,271,226z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>

                                    <span>
                                    Visits left: {{$shop->availableViews}}
                                </span>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>



            @else
                <div class="disconected-instagram" style="background: url('{{asset('images/illustration.png')}}')">
                    <div class="content-disc">
                        <h2>Connect your Instagram account to view your photos</h2>
                        <div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf" style="padding: 10px 15px; display: flex; justify-content: flex-end;">
                            <button type="button" class="Polaris-Button Polaris-Button--primary" style="padding: 0;">
                                <span class="Polaris-Button__Content" style="height: 100%;">
                                    <span class="Polaris-Button__Text" style="height: 100%;">
                                        <a target="_blank" href="{{$instagramConnect}}" style="height: 100%; display: flex; align-items: center; padding: 0 15px; color: #fff; text-decoration: none;">Connect an Instagram Account</a>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <style>
        #popup_window .image_view img{
            cursor: url({{asset('/images/cursor_select.png')}});
        }
    </style>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Dashboard App',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
    <script src="{{asset('js/app.js')}}"></script>
@endsection
