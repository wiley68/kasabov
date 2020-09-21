<?php use App\City; ?>
<?php use App\User; ?>
<?php use App\Product; ?>

@extends('layouts.adminLayout.admin_design')


@section('content')
<script type="text/javascript">
    function deleteOrder(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита заявката. Операцията е невъзвратима!",
            icon: "warning",
            buttons: ["Отказ!", "Съгласен съм!"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            window.location = url;
        } else {
            return false;
        }
        });
        return false;
    };
</script>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел"
                class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-orders') }}"
                class="current">Всички заявки</a></div>
        <h1>Търговци</h1>
        @if (Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
        @endif
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Всички заявки</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Заявка №</th>
                                    <th>Дата</th>
                                    <th>Клиент</th>
                                    <th>Продукт</th>
                                    <th>Търговец</th>
                                    <th>Управление</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                @php
                                    $product = Product::where(['id'=>$order->product_id])->first();
                                @endphp
                                <tr class="gradeX">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ date("d.m.Y H:i:s", strtotime($order->created_at)) }}</td>
                                    <td>{{ User::where(['id'=>$order->user_id])->first()->name }}</td>
                                    <td>
                                    @if ($product)
                                        {{$product->product_name}}
                                    @endif
                                    </td>
                                    @php
                                        if($product){
                                            $targovec_id = $product->user_id;
                                            $targovec_name = User::where(['id'=>$targovec_id])->first()->name;
                                        }
                                        else{
                                            $targovec_name = "";
                                        }
                                    @endphp
                                    <td>{{ $targovec_name }}</td>
                                    <td class="center">
                                        <a href="#modalPregled{{ $order->id }}" data-toggle="modal" class="btn btn-success btn-mini">Преглед</a>
                                        <a href="{{ route('admin.edit-order', ['id' => $order->id]) }}" class="btn btn-primary btn-mini">Редактирай</a>
                                        <a onclick="deleteOrder('{{ route('admin.delete-order', ['id' => $order->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a>
                                    </td>
                                </tr>
                                <div id="modalPregled{{ $order->id }}" class="modal hide">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>Заявка №: {{ $order->id }} - Подробен преглед</h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="controls controls-row">
                                            <div class="span6 m-wrap">
                                                <p>От дата: {{ date("d.m.Y H:i:s", strtotime($order->created_at)) }}</p>
                                                <p>Клиент: {{ User::where(['id'=>$order->user_id])->first()->name }}</p>
                                                <p>E-Mail: {{ $order->email }}</p>
                                                <p>Телефон: {{ $order->phone }}</p>
                                                <p>Продукт: @if ($product) {{$product->product_name}} @endif</p>
                                                <p>Търговец: {{ $targovec_name }}</p>
                                                <p>Съобщение: {{ $order->message }}</p>
                                            </div>
                                            <div class="span6 m-wrap">
                                                @if ($product)
                                                    <p><img src="{{ asset('/images/backend_images/products/small/'.$product->image) }}" /></p>                                                    
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer"><a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a> </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
