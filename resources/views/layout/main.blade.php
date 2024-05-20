@include('layout.header')
<body id="kt_body" style="background-color:#F6F5EA">

    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
   

    <div class="d-flex flex-column flex-root">

        <div class="page d-flex flex-row flex-column-fluid">
            @include('layout.sidebar')

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <div id="kt_header" class="header">

                    <div class="container-fluid d-flex align-items-center flex-wrap justify-content-between"
                        id="kt_header_container">

                        <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 pb-5 pb-lg-0 pt-7 pt-lg-0"
                            data-kt-swapper="true" data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">

                            {{-- <h1 class="d-flex flex-column text-gray-900 fw-bold my-0 fs-1">{{$menuname}}</h1> --}}
                            <h1 class="d-flex flex-column text-gray-900 fw-bold my-0 fs-1">{{$nama_menu}}</h1>

                        </div>
                        <div class="d-flex d-lg-none align-items-center ms-n4 me-2">								
								<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
									<i class="ki-duotone ki-abstract-14 fs-1 mt-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0">                                                        
                            <div class="d-flex align-items-center ms-3 ms-lg-4">                                
                                <a href="#" class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    <i class="ki-solid ki-profile-circle theme-light-show fs-1">
                                        
                                    </i>
                                    
                                </a>                                                                
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">                                    
                                    <div class="menu-item px-3 my-0">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="menu-link px-3 py-2">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-exit-left fs-2"></i>
                                                </span>
                                                <span class="menu-title">Logout</span>
                                            </button>
                                        </form>
                                    </div>                                    
                                </div>
                               
                            </div>                                                                                    
                        </div>
                    </div>

                </div>


                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <div class="container-fluid" id="kt_content_container">
                        @yield('content')
                    </div>

                </div>

            </div>

        </div>

    </div>
    
    <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
    <script src="{{asset('assets/js/custom/widgets.js')}}"></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/flipbook/min_version/pdf.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/real3d-flip-book/js/flipbook.min.js') }}"></script>
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    @yield('javascript')
</body>