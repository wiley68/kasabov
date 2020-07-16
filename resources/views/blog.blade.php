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
                            <div class="short-name">
                                @php
                                    $current_page = 1;
                                    if (!empty(request('page'))){
                                        $current_page = intval(request('page'));
                                    }
                                    $start_posts_count = ($current_page - 1) * $paginate + 1;
                                    $end_posts_count = $start_posts_count + $blog->count() - 1;
                                @endphp
                                <span>Показани ({{ $start_posts_count }} - {{ $end_posts_count }} публикации от общо {{ $all_posts_count }} публикации)</span>
                            </div>
                            @php
                                $count = $blog->count();
                            @endphp
                            @foreach ($blog as $post)
                            <div class="row">
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
                            </div>
                            @if($count > 1)
                                <hr>
                            @endif
                            @php
                                $count--;
                            @endphp
                            @endforeach
                            <br/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">                        
                                    <!-- Start Pagination -->
                                    {{ $blog->links() }}
                                    <!-- End Pagination -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">                        
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection