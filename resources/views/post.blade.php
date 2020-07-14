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
                                <div class="panel-image">
                                    @php
                                    $image = asset('/images/backend_images/blog/'.$post->image);
                                    @endphp
                                    @if(!empty($post->image))
                                    <img class="img-fluid" src="{{$image}}" alt="">
                                    @endif
                                </div>
                                <div class="content-wrapper">
                                    <div class="feature-content">
                                        <h4>{{ $post->title }}</h4>
                                        <p>{!! $post->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection