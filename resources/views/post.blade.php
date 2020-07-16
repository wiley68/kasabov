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
                                    $image = asset('/images/backend_images/blog/large/'.$post->image);
                                    @endphp
                                    @if(!empty($post->image))
                                    <img class="img-fluid" src="{{$image}}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="feature-content" style="width:100%;">
                                    <h4 style="text-align:center;">{{ $post->title }}</h4>
                                    <p>{!! $post->description !!}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="feature-content" style="width:100%;">
                                    <a class="btn btn-common fullwidth mt-4" href="{{ route('blog') }}">Върни се обратно в Блог</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection