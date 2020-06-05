@extends('layouts.frontLayout.front_design_index')
@section('content')
    <section id="text_content" class="section-padding">
        <div class="container">
            {!! $page->value_hp !!}
        </div>
    </section>
@endsection
