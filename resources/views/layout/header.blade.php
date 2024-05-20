<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');?>

<head>
    <title>LIVRA</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    {{-- <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" /> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="LIVRA" />
    {{-- <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/media/logos/Livra Logo.png') }}" /> --}}
    <link href="{{ asset('assets/media/logos/Livra Logo.png') }}" type="image/png" rel="icon">
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/real3d-flip-book/css/flipbook.style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/real3d-flip-book/css/font-awesome.css') }}">
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet">
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
    <style type="text/css">
        @media (max-width: 991.98px){
            .aside-logo {
                display: block !important;
            }
            .img-logo{
                height: 95px !important;    
            }

        }

        @media (max-width: 991.98px){
            .logo-utama {
                display: none !important;
            }
        }

        .menu-link{
            color: #3A69B2 !important;
        }

        .active{
            transition: color .2s ease !important;
            background-color: #3a69b2 !important;
            color: white !important;
        }
        .caret{
        
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: 2px;
        vertical-align: middle;
        border-top: 4px dashed;
        border-top: 4px solid\9;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
        }
        
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none;
        }

        .custom-form-input{
            background:transparent !important;
            border:none !important;
            box-shadow: none !important;
        }
        .loader2 {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 15px;
            height: 15px;
            animation: spin 2s linear infinite;
            margin: auto auto 1% auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        } 

        

    </style>
    
    <style type="text/css"> 
        * {
        outline: none !important;
        }
        body {
        text-align: center;
        }
        .page-wrapper {
        width: 1280px;
        text: left;
        display: inline-block;
        }
        .playlist-wrapper {
        display: flex;
        }
        .playlist-child-videos {
        display: flex;
        flex-direction: row;
        }
        .playlist-item-wrapper {
        display: inline-block;
        }
        .playlist-child-videos {
        overflow: auto;
        /* height: 100%; */
        }
        .playlist-item-wrapper {
        margin: 10px;
        margin-left: 0 !important;
        /* padding: 10px;
        max-width: 320px; */
        }
        .playlist-thumb {
        position: relative;
        }
        .playlist-thumb img {
        width: 320px;
        }
        .playlist-meta-length {
        font-weight: bold;
        position: absolute;
        bottom: 10px;
        right: 10px;
        z-index: 3;
        background-color: rgba(0,0,0,.7);
        color: #fff;
        padding: 0 10px;
        border-radius: 3px;
        }
        .playlist-item-wrapper[data-playing="true"] .playlist-thumb img {
        opacity: 0.5;
        }
        .playlist-item-wrapper[data-live="true"] .playlist-meta-length {
        color: #dd3333;
        }
        .playlist-item-wrapper[data-live="true"] .playlist-meta-length:before {
        border-radius: 100%;
        margin-right: 5px;
        animation: blink 1300ms 0s ease infinite;
        content: "•";
        display: inline-block;
        vertical-align: middle;
        }
        .playlist-item-wrapper .playlist-meta-length > span {
        display: inline-block;
        vertical-align: middle;
        }
        @keyframes blink {
        from {
            opacity: 0;
        }
        25% {
            opacity: 1;
        }
        75% {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
        }
    </style>
    
</head>