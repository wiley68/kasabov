@extends('layouts.frontLayout.front_design')

@section('content')
<div style="padding-bottom:30px;"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Настройки профил</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Добре дошли в PartyBox!
                </div>
            </div>
        </div>
    </div>
</div>
<div style="padding-bottom:30px;"></div>
@endsection
