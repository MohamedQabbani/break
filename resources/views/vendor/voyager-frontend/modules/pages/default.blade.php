@php if (empty($layout)) $layout = 'default'; @endphp
@extends('voyager-frontend::layouts.' . $layout)
@section('meta_title', $page->title)
@section('meta_description', $page->meta_description)
@section('page_title', $page->title)
@section('page_banner', imageUrl($page->image, 1200, 211))

@section('content')
    <div class="row">
        @foreach($places as $place)
            <div class="col-md-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ url('storage/'.json_decode($place->image, 1)[0]) }}"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $place->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $place->location }}</h6>
                        <p class="card-text">{{ str_limit($place->description, 50) }}</p>
                        <a href="#" class="btn btn-primary">التفاصيل</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
