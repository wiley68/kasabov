<?php

use App\Holiday; ?>
@extends('layouts.frontLayout.front_design_index')
@section('content')
<section id="text_content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 page-content">
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show">
                            <div class="row">
                                @foreach ($blog as $post)
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="panel-image">
                                            @php
                                            $image = asset('/images/backend_images/blog/large/'.$post->image);
                                            @endphp
                                            @if(!empty($post->image))
                                            <a href="{{ route('post', ['id' => $post->id]) }}"><img class="img-fluid" src="{{$image}}" alt=""></a>
                                            @endif
                                            </div>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="{{ route('post', ['id' => $post->id]) }}">{{ $post->title }}</a></h4>
                                                <p>{!! Str::words($post->description,100) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection