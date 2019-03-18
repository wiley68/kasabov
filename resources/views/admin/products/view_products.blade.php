<?php use App\Http\Controllers\CategoryController; ?>
<?php use App\Http\Controllers\SpeditorController; ?>
<?php use App\Http\Controllers\CityController; ?>
<?php use App\User; ?>
<?php use App\ProductsTags; ?>
<?php use App\Tag; ?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteProduct(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрит записът за този продукт. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}" class="current">Всички продукти</a> <a href="{{ route('admin.add-product') }}">Добави продукт</a></div>
      <h1>Продукти</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Всички продукти</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Продукт №</th>
                    <th>Код</th>
                    <th>Продукт</th>
                    <th>Категория</th>
                    <th>Собственик</th>
                    <th>Цена</th>
                    <th>Снимка</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="gradeX">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ CategoryController::getCategoryById($product->category_id)->name }}</td>
                            <td>{{ User::where(['id'=>$product->user_id])->first()->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                @if (!empty($product->image))
                                <a href="#imageModal{{ $product->id }}" data-toggle="modal" title="Покажи снимката в голям размер."><img src="{{ asset('/images/backend_images/products/small/'.$product->image) }}" style="width:50px;"></a>
                                @endif
                            </td>
                            <td class="center">
                                <a href="#modalPregled{{ $product->id }}" data-toggle="modal" class="btn btn-success btn-mini">Преглед</a>
                                <a href="{{ route('admin.edit-product', ['id' => $product->id]) }}" class="btn btn-primary btn-mini">Редактирай</a>
                                <a href="{{ route('admin.add-images', ['id' => $product->id]) }}" class="btn btn-info btn-mini">Снимки</a>
                                <a onclick="deleteProduct('{{ route('admin.delete-product', ['id' => $product->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a>
                            </td>
                        </tr>
                        <div id="modalPregled{{ $product->id }}" class="modal hide">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>{{ $product->product_name }} - Подробен преглед</h3>
                            </div>
                            <div class="modal-body">
                                <div class="controls controls-row">
                                    <div class="span6 m-wrap">
                                        <p><strong>Продукт №:</strong> {{ $product->id }}</p>
                                        <p><strong>Код:</strong> {{ $product->product_code }}</p>
                                        <p><strong>Наименование:</strong> {{ $product->product_name }}</p>
                                        <p><strong>Собственик:</strong> {{ User::where(['id'=>$product->user_id])->first()->name }}</p>
                                        <p><strong>Категория:</strong> {{ CategoryController::getCategoryById($product->category_id)->name }}</p>
                                        <p><strong>Количество:</strong> {{ $product->quantity }}</p>
                                        <p><strong>Цена:</strong> {{ $product->price }}</p>
                                        <p><strong>Основен цвят:</strong> <i class="icon-stop" style="color:{{ $product->first_color }};"></i></p>
                                        <p><strong>Втори цвят:</strong> <i class="icon-stop" style="color:{{ $product->second_color }};"></i></p>
                                        @php
                                        switch ($product->age) {
                                            case 'child':
                                                $age_txt = 'За деца';
                                                break;
                                            case 'adult':
                                                $age_txt = 'За възрастни';
                                                break;
                                        }
                                        @endphp
                                        <p><strong>Възрастова група:</strong> {{ $age_txt }}</p>
                                        @php
                                        switch ($product->pol) {
                                            case 'woman':
                                                $pol_txt = 'За жени';
                                                break;
                                            case 'man':
                                                $pol_txt = 'За мъже';
                                                break;
                                        }
                                        @endphp
                                        <p><strong>Пол:</strong> {{ $pol_txt }}</p>
                                        @php
                                        switch ($product->condition) {
                                            case 'old':
                                                $condition_txt = 'Употребяван';
                                                break;
                                            case 'new':
                                                $condition_txt = 'Нов';
                                                break;
                                        }
                                        @endphp
                                        <p><strong>Състояние:</strong> {{ $condition_txt }}</p>
                                        <p><strong>Изпраща се с:</strong> {{ SpeditorController::getSpeditorById($product->send_id)->name }}</p>
                                        <p><strong>Изпраща се от:</strong> {{ CityController::getCityById($product->send_from_id)->city }}&nbsp;, област: {{ CityController::getCityById($product->send_from_id)->oblast }}</p>
                                        <p><strong>Цена за изпращане:</strong> {{ $product->price_send }}</p>
                                        <p><strong>Безплатна доставка:</strong> @if ($product->send_free === 1) Да @else Не @endif</p>
                                        <p><strong>Важи за:</strong> {{ $product->send_free_id }}</p>
                                        @php
                                        switch ($product->available_for) {
                                            case 'city':
                                                $available_for_txt = 'Населено място';
                                                break;
                                            case 'cities':
                                                $available_for_txt = 'Населени места';
                                                break;
                                            case 'area':
                                                $available_for_txt = 'Област';
                                                break;
                                            case 'country':
                                                $available_for_txt = 'Цялата страна';
                                                break;
                                        }
                                        @endphp
                                        <p><strong>Доставя за:</strong> {{ $available_for_txt }}</p>
                                        <p><strong>Може да се вземе от обект:</strong> @if ($product->object == 1) Да @else Не @endif</p>
                                        <p><strong>Адрес на обекта:</strong> {{ $product->object_name }}</p>
                                        <p><strong>Възможност за персонализиране:</strong> @if ($product->personalize == 1) Да @else Не @endif</p>
                                    </div>
                                    <div class="span6 m-wrap">
                                        <p><img src="{{ asset('/images/backend_images/products/medium/'.$product->image) }}"/></p>
                                        <p><strong>ЕТИКЕТИ:</strong></p>
                                        @foreach (ProductsTags::where(['product_id'=>$product->id])->get() as $product_tag)
                                            <span class="label label-success">{{ Tag::where(['id'=>$product_tag->tag_id])->first()->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="controls controls-row">
                                    <div class="span12 m-wrap">
                                        <p><strong>Описание:</strong> {!! $product->description !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"><a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a> </div>
                        </div>
                        <div id="imageModal{{ $product->id }}" class="modal hide" aria-hidden="true" style="display: none;">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>Снимка на продукта: {{ $product->product_name }}</h3>
                            </div>
                            <div class="modal-body">
                                <p><img src="{{ asset('/images/backend_images/products/large/'.$product->image) }}"></p>
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
