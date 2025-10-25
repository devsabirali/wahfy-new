<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charitics - NGO & Non Profit HTML Template</title>

    <!-- libraries CSS -->
    <link rel="stylesheet" href="{{asset('assets/icon/flaticon_charitics.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/splide/splide.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slim-select/slimselect.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/animate-wow/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/flatpickr/flatpickr.min.css')}}">
    @php
    $favicon = collect($settings['media'])->firstWhere('key', 'favicon');
    @endphp
    @if($favicon)
        <link rel="shortcut icon" href="{{ Storage::url($favicon->value) }}" type="image/x-icon">
    @endif
    <!-- custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>
