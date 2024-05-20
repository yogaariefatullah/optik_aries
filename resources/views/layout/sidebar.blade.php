@php
    $menu = getAllMenu();
@endphp
<div id="kt_aside" style="background-color:white!important;" class="aside pt-7 pb-4 pb-lg-7 pt-lg-17" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_toggle">
    <div class="aside-logo flex-column-auto px-9 mb-9 mb-lg-17 mx-auto">
        <img alt="Logo" src="{{asset('assets/media/logos/logo pusdikif.png')}}" style="height:100px;"class="logo img-logo theme-light-show">
                                        
        <img alt="Logo" src="{{asset('assets/media/logos/Livra Logo.png')}}" style="height:100px;"class="logo img-logo theme-light-show">
    </div>
    <div class="aside-menu flex-column-fluid ps-3 ps-lg-5 pe-1 mb-9" id="kt_aside_menu">
        <div class="w-100 hover-scroll-y pe-2 me-2" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_user, #kt_aside_footer"
            data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="0">
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
                @foreach($menu as  $value)
                    <?php $check = getPermission(Auth::user()->group_id,$value->id)?>
                    @if($check)
                        @if($value->url != '#' && $value->parent_id == 0)
                            @if($check->r != null || $check->r != false )    
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Str::contains(request()->url(), $value->url)  ? 'show' : '' }}">
                                    <div class="menu-item">
                                        <a class="{{ Str::contains(request()->url(), $value->url) ? 'menu-link active' : 'menu-link' }}" href="{{ url($value->url) }}">
                                            {{$value->name}}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @elseif($value->url == '#' && $value->parent_id == 0)
                            @php
                                $Child = getChild($value->id);
                            @endphp
                            @if($check->r != null || $check->r != false ) 
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Str::contains(request()->url(), $value->url)  ? 'show' : '' }}">
                                    <span class="menu-link">
                                        <span class="menu-title">{{$value->name}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion {{ Str::contains(request()->url(), $value->url) ? 'show' : '' }}">
                                        @foreach($Child as  $value_child)
                                            <?php $check_child = getPermission(Auth::user()->group_id,$value_child->id)?>
                                            @if($check_child->r != null || $check_child->r != false ) 
                                                <div class="menu-item">
                                                    <a class="{{ Str::contains(request()->url(), $value_child->url) ? 'menu-link active' : 'menu-link' }}" href="{{ url($value_child->url) }}">
                                                        {{$value_child->name}}
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="aside-footer flex-column-auto px-6 px-lg-9" id="kt_aside_footer">
        <div class="d-flex flex-stack ms-7">
            <a href="authentication/flows/basic/sign-in.html"
                class="btn btn-sm btn-icon btn-active-color-primary btn-icon-gray-600 btn-text-gray-600">
                <i class="ki-duotone ki-entrance-left fs-1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <span class="d-flex flex-shrink-0 fw-bold">Log Out</span>
            </a>
        </div>
    </div>
</div>