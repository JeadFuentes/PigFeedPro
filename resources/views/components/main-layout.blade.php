<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PigFeedPro</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @livewireStyles
        @vite(['resources/sass/app.scss','resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="{{"storage/PigFeedPro.png"}}" alt="PigFeedPro">
                    </span>
    
                    <div class="text logo-text">
                        <span class="name">PigFeedPro</span>
                    </div>
                </div>
    
                <i class='bx bx-chevron-right toggle'></i>
            </header>
    
            <div class="menu-bar">
                <div class="menu">
    
                    <!--<li class="search-box">
                        <i class='bx bx-search icon'></i>
                        <input type="text" placeholder="Search...">
                    </li>-->

                    <ul class="menu-links" style="padding-left: 0">
                        @if ($level <= 30)
                            <li class="nav-link">
                                <a href="{{route('dashboard')}}">
                                    <i class='bx bx-home-alt icon' ></i>
                                    <span class="text nav-text">Dashboard</span>
                                </a>
                            </li>
        
                            <li class="nav-link">
                                <a href="{{route('report')}}">
                                    <i class='bx bx-bar-chart-alt-2 icon' ></i>
                                    <span class="text nav-text">Reports</span>
                                </a>
                            </li>
                        
                            <li class="nav-link" style="background-color: red;">
                                <a href="{{route('monitoring')}}">
                                    <i class='bx bx-bell icon'></i>
                                    <span class="text nav-text">Feed Monitoring !</span>
                                </a>
                            </li>  
                        @else
                            <li class="nav-link">
                                <a href="{{route('dashboard')}}">
                                    <i class='bx bx-home-alt icon' ></i>
                                    <span class="text nav-text">Dashboard</span>
                                </a>
                            </li>
        
                            <li class="nav-link">
                                <a href="{{route('report')}}">
                                    <i class='bx bx-bar-chart-alt-2 icon' ></i>
                                    <span class="text nav-text">Reports</span>
                                </a>
                            </li>
                            <li class="nav-link">
                                <a href="{{route('monitoring')}}">
                                    <i class='bx bx-bell icon'></i>
                                    <span class="text nav-text">Feed Monitoring</span>
                                </a>
                            </li>  
                        @endif
                    </ul>
                </div>
    
                <div class="bottom-content">
                    <!--<li class="">
                        <a href="#">
                            <i class='bx bx-log-out icon' ></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>-->
    
                    <li class="mode">
                        <div class="sun-moon">
                            <i class='bx bx-moon icon moon'></i>
                            <i class='bx bx-sun icon sun'></i>
                        </div>
                        <span class="mode-text text">Light mode</span>
    
                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
    
                </div>
            </div>
    
        </nav>
    
        <section class="home">
            <div class="text">{{$pageName}}</div>
            {{$slot}}
        </section>

        @livewireScripts
        <script>
        const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text");


        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        })

        const savedMode = localStorage.getItem('theme');

        if (savedMode === 'dark') {
            body.classList.add('dark');
            modeText.innerText = "Light mode";
        } else {
            body.classList.remove('dark');
            modeText.innerText = "Dark mode";
        }

        modeSwitch.addEventListener("click", () => {
            body.classList.toggle("dark");

            if (body.classList.contains("dark")) {
                localStorage.setItem('theme', 'dark');
                modeText.innerText = "Light mode";
            } else {
                localStorage.setItem('theme', 'light');
                modeText.innerText = "Dark mode";
            }
        });

        </script>
    </body>
</html>