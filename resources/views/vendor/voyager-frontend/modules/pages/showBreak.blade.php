@php if (empty($layout)) $layout = 'default'; @endphp
@extends('voyager-frontend::layouts.' . $layout)
@section('meta_title', $page->title)
@section('meta_description', $page->meta_description)
@section('page_title', $page->title)
@section('page_banner', imageUrl($page->image, 1200, 211))

@section('content')
    <div class="row d-flex p-5" style="text-align: center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary">
                    {{ $place->title }} -
                    {{ $place->location }} -
                    {{ $place->mobile }} -
                    تاريخ النشر
                    {{ date('d-m-Y', strtotime($place->created_at)) }}
                </div>
                <div class="card-body">
                    <p class="card-text" style="direction: rtl;">{!! $place->description !!}</p>
                    @foreach(json_decode($place->image, 1) as $image)
                        <img class="card-img-bottom img-fluid w-50 p-2" src="{{ url('storage/'.$image) }}"
                             alt="">
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
