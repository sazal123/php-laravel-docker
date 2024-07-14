<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    <button id="fb-login-btn">Login with Facebook</button>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1087087365982506', // Replace with your app ID
                cookie     : true,
                xfbml      : true,
                version    : 'v19.0'  // Replace with the API version you are using
            });

            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>
        function handleLoginResponse(response) {
            if (response.authResponse) {
                console.log('Welcome! Fetching your information....');
                FB.api('/me', function(response) {
                    console.log('Good to see you, ' + response.name + '.');
                    fetchPages(); // Fetch pages after successful login
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        }

        function fetchPages() {
            FB.api('/me/accounts', function(response) {
                if (response && !response.error) {
                    console.log('Pages you manage:', response);
                    // Automatically select the page or handle the selection logic here
                    if (response.data.length > 0) {
                        let page = response.data[0]; // Automatically select the first page
                        console.log('Automatically selected page:', page);
                        // Additional logic to handle the selected page
                    } else {
                        console.log('No pages found.');
                    }
                } else {
                    console.error('Error fetching pages', response.error);
                }
            });
        }

        document.getElementById('fb-login-btn').addEventListener('click', function() {
            FB.login(handleLoginResponse, {scope: 'pages_show_list,leads_retrieval, pages_manage_metadata,pages_manage_ads,ads_management,ads_read'});
        });
    </script>
    </body>
</html>
