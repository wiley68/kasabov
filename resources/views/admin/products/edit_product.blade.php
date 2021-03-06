<?php use App\Category; ?>
<?php use App\Holiday; ?>
<?php use App\Tag; ?>
<?php use App\City; ?>
<?php use App\ProductsCity; ?>
<?php use App\ProductsCitySend; ?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<script type="text/javascript">
    function deleteProductImage(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита снимката за този продукт. Операцията е невъзвратима!",
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
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}">Всички продукти</a> <a href="{{ route('admin.edit-product', ['id'=>$product->id]) }}">Редактирай продукт</a> </div>
        <h1>Редакция на продукт</h1>
        @if (Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
        @endif
        @if (Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
        @endif
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-product', ['id'=>$product->id]) }}"
                name="edit_product" id="edit_product" novalidate="novalidate">
                @csrf
                <input type="hidden" id="product_id" value="{{ $product->id }}">
                <div class="span5">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Информация за продукта</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Собственик *</label>
                                <div class="controls">
                                    <select name="user_id" id="user_id" style="width:314px;">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($user->id === $product->user_id) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Категория *</label>
                                <div class="controls">
                                    <select name="category_id" id="category_id" style="width:314px;">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if ($category->id === $product->category_id) selected @endif>{{ $category->name }}</option>
                                            @foreach (Category::where(['parent_id'=>$category->id])->get() as $item)
                                                <option value="{{ $item->id }}" @if ($item->id === $product->category_id) selected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Празник</label>
                                <div class="controls">
                                    <select name="holiday_id" id="holiday_id" style="width:314px;">
                                        <option value="0" @if (0 === $product->holiday_id) selected @endif selected>Избери празник</option>
                                        @foreach ($holidays as $holiday)
                                            <option value="{{ $holiday->id }}" @if ($holiday->id === $product->holiday_id) selected @endif>{{ $holiday->name }}</option>
                                            @foreach (Holiday::where(['parent_id'=>$holiday->id])->get() as $item)
                                                <option value="{{ $item->id }}" @if ($item->id === $product->holiday_id) selected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Продукт *</label>
                                <div class="controls">
                                    <input type="text" name="product_name" id="product_name" value="{{ $product->product_name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Код *</label>
                                <div class="controls">
                                    <input type="text" name="product_code" id="product_code" value="{{ $product->product_code }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Цена *</label>
                                <div class="controls">
                                    <input type="number" name="price" id="price" value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Заглавна снимка</label>
                                <div class="controls">
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" id="current_image" value="{{ $product->image }}">
                                    @if (!empty($product->image))
                                        <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}"></a> | <a onclick="deleteProductImage('{{ route('admin.delete-product-image', ['id' => $product->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Възрастова група</label>
                                <div class="controls">
                                    <select name="age" id="age" style="width:314px;">
                                        <option value="any" @if ($product->age === 'age') selected @endif>Без значение</option>
                                        <option value="child" @if ($product->age === 'child') selected @endif>За деца</option>
                                        <option value="adult" @if ($product->age === 'adult') selected @endif>За възрастни</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Изпраща се с</label>
                                <div class="controls">
                                    <select name="send_id" id="send_id" style="width:314px;">
                                        <option value="0" selected>Избери доставчик</option>
                                        @foreach ($speditors as $speditor)
                                            <option value="{{ $speditor->id }}" @if ($speditor->id === $product->send_id) selected @endif>{{ $speditor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Изпраща се от</label>
                                <div class="controls">
                                    @php
                                        if(!empty(City::where(['id'=>$product->send_from_id])->first())){
                                            $send_from_id_name = City::where(['id'=>$product->send_from_id])->first()->city . '-' . City::where(['id'=>$product->send_from_id])->first()->oblast;
                                        }else{
                                            $send_from_id_name = '';
                                        }
                                    @endphp
                                    <input type="text" name="send_from_id_txt" id="send_from_id_txt" value="{{ $send_from_id_name }}" />
                                    <input type="hidden" name="send_from_id" id="send_from_id" value="{{ $product->send_from_id }}" />
                                    <a id="btn_send_from_id" href="#choose_city_form" data-toggle="modal" title="Избери населено място" class="btn btn-success btn-mini">Избери</a>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Цена на доставка</label>
                                <div class="controls">
                                    <input type="number" name="price_send" id="price_send" value="{{ $product->price_send }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Безплатна доставка</label>
                                <div class="controls">
                                    <select name="send_free" id="send_free" style="width:314px;">
                                        <option value=1 @if ($product->send_free === 1) selected @endif>Да</option>
                                        <option value=0 @if ($product->send_free === 0) selected @endif>Не</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Офертата важи за:</label>
                                <div class="controls">
                                    <select name="send_free_available_for" id="send_free_available_for" style="width:314px;">
                                        <option value="country" @if ($product->send_free_available_for === 'country') selected @endif>Цялата страна</option>
                                        <option value="city" @if ($product->send_free_available_for === 'city') selected @endif>Населено място</option>
                                        <option value="cities" @if ($product->send_free_available_for === 'cities') selected @endif>Населени места</option>
                                        <option value="area" @if ($product->send_free_available_for === 'area') selected @endif>Област</option>
                                    </select>
                                </div>
                            </div>
                            <div id="send_free_available_for_send_free_id_div" class="control-group">
                                <label class="control-label">Избери</label>
                                <div class="controls">
                                    @php
                                        if(!empty(City::where(['id'=>$product->send_free_id])->first())){
                                            $city_name = City::where(['id'=>$product->send_free_id])->first()->city . '-' . City::where(['id'=>$product->send_free_id])->first()->oblast;
                                        }else{
                                            $city_name = '';
                                        }
                                    @endphp
                                    <input type="text" name="send_free_id_txt" id="send_free_id_txt" value="{{ $city_name }}" />
                                    <input type="hidden" name="send_free_id" id="send_free_id" value="{{ $product->send_free_id }}" />
                                    <a id="btn_send_free_id" href="#choose_city_form" data-toggle="modal" title="Избери населено място" class="btn btn-success btn-mini">Избери</a>
                                </div>
                            </div>
                            <div id="send_free_available_for_oblast_div" class="control-group">
                                <label class="control-label">Избери</label>
                                <div class="controls">
                                    <select name="send_free_oblast" id="send_free_oblast" style="width:314px;">
                                        <option value="0" selected>Избери област</option>
                                        @foreach ($cities as $city)
                                            @if($city->city === $city->oblast)
                                            <option value="{{ $city->id }}" @if ($product->send_free_id === $city->id) selected @endif>{{ $city->city }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="send_free_available_for_cities_div" class="control-group">
                                <label class="control-label">Избери</label>
                                <div class="controls">
                                    <select multiple name="send_free_available_for_cities[ ]" id="send_free_available_for_cities" style="width:314px;">
                                        @foreach ($cities as $city)
                                            @php
                                                $send_free_city_arr = [];
                                                foreach (ProductsCitySend::where(['product_id'=>$product->id])->get() as $product_city) {
                                                    $send_free_city_arr[] = $product_city->city_id;
                                                }
                                            @endphp
                                            <option value="{{ $city->id }}" @if (in_array($city->id, $send_free_city_arr)) selected @endif>{{ $city->city }}&nbsp;--&nbsp;{{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Може да се вземе от обект</label>
                                <div class="controls">
                                    <select name="object" id="object" style="width:314px;">
                                        <option value=0 @if ($product->object === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->object === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Адрес на обекта</label>
                                <div class="controls">
                                    <input type="text" name="object_name" id="object_name" value="{{ $product->object_name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Възможност за персонализиране</label>
                                <div class="controls">
                                    <select name="personalize" id="personalize" style="width:314px;">
                                        <option value=0 @if ($product->personalize === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->personalize === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Запиши промените" class="btn btn-success">
                                <a href="{{ route('admin.view-products') }}" class="btn btn-primary">Обратно в продукти</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Описание на продукта</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div style="padding:10px;">
                                <textarea name="description" id="description" class="span12" rows="5">{!! $product->description !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Етикети</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div style="padding:10px;">
                                <input type="text" name="tag_add" id="tag_add"> <button id="btn_add_tag" class="btn btn-primary">Добави етикета</button>
                                <div style="padding-top: 10px;" id="div_tags">
                                    @if (!empty($tags))
                                        @foreach ($tags as $tag)
                                        <p><span class="label label-success">{{ Tag::where(['id'=>$tag->tag_id])->first()->name }}</span><input type="hidden" name="tags[]" value="{{ Tag::where(['id'=>$tag->tag_id])->first()->name }}"> <span onclick="removeTag(this);" style="color:red;cursor:pointer;">Изтрий</span></p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Системни настройки</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="control-group">
                                <label class="control-label">Статус</label>
                                <div class="controls">
                                    <select name="status" id="status" style="width:314px;">
                                        <option value='active' @if ($product->status === 'active') selected @endif>Активен</option>
                                        <option value='notactive' @if ($product->status === 'notactive') selected @endif>Неактивен</option>
                                        <option value='sold' @if ($product->status === 'sold') selected @endif>Продаден</option>
                                        <option value='expired' @if ($product->status === 'expired') selected @endif>Изтекъл</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="control-group">
                                <label class="control-label">Активиран на</label>
                                <div class="controls">
                                    <input type="text" disabled name="active_at" id="active_at" value="{{ date('d.m.Y', strtotime(date($product->active_at))) }}"> <button id="btn_activate" class="btn btn-primary">Активирай отново</button>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content nopadding">
                                <div class="control-group">
                                    <label class="control-label">Промоционален</label>
                                    <div class="controls">
                                        <select name="featured" id="featured" style="width:314px;">
                                            <option value=0 @if ($product->featured === 0) selected @endif>Не</option>
                                            <option value=1 @if ($product->featured === 1) selected @endif>Да</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content nopadding">
                            <div class="control-group">
                                <label class="control-label">Топ продукт</label>
                                <div class="controls">
                                    <select name="top" id="top" style="width:314px;">
                                        <option value=0 @if ($product->top === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->top === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="control-group">
                                <label class="control-label">Харесвания</label>
                                <div class="controls">
                                    <input type="number" name="likes" id="likes" value="{{ $product->likes }}">
                                </div>
                            </div>
                        </div>
                        <div class="widget-content nopadding">
                                <div class="control-group">
                                    <label class="control-label">Преглеждания</label>
                                    <div class="controls">
                                        <input type="number" name="views" id="views" value="{{ $product->views }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </form>
            <div id="imageModal" class="modal hide" aria-hidden="true" style="display: none;">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>Снимка на продукта: {{ $product->product_name }}</h3>
                </div>
                <div class="modal-body">
                    <p><img src="{{ asset('/images/backend_images/products/large/'.$product->image) }}"></p>
                </div>
                <div class="modal-footer"><a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a> </div>
            </div>
        </div>
    </div>
</div>
<!-- Choose city form -->
<div id="choose_city_form" class="modal hide" style="width:900px;min-height:560px;">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Избери населено място</h3>
        </div>
        <div class="modal-body" style="min-height:560px;">
            <div class="container-fluid">
                <div class="row-fluid">
                    <table id="table_city" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Населено място</th>
                                <th>Област</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $city)
                            <tr class="gradeX">
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->oblast }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-primary" id="btn_select_city">Избери</button>
            <a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a>
        </div>
    </div>
    @endsection

@section('scripts')
    <script>
        // Save clicked ciry choose button
        var city_btn_click = 0;

        // Select city row
        $('#table_city tbody').on( 'click', 'tr', function () {
    		if ( $(this).hasClass('selected_tr') ) {
	    		$(this).removeClass('selected_tr');
	    	} else {
			    $('#table_city tbody tr').removeClass('selected_tr');
			    $(this).addClass('selected_tr');
		    }
	    });

        // Hide all city chooses
        function hideAllsend_free(){
            switch ($('#send_free_available_for').val()) {
                case 'country':
                    $('#send_free_available_for_send_free_id_div').hide();
                    $('#send_free_available_for_oblast_div').hide();  
                    $('#send_free_available_for_cities_div').hide();            
                    break;
                case 'city':
                    $('#send_free_available_for_send_free_id_div').show();
                    $('#send_free_available_for_oblast_div').hide();
                    $('#send_free_available_for_cities_div').hide();
                    break;
                case 'cities':
                    $('#send_free_available_for_send_free_id_div').hide();
                    $('#send_free_available_for_oblast_div').hide();
                    $('#send_free_available_for_cities_div').show();
                    break;
                case 'area':
                    $('#send_free_available_for_send_free_id_div').hide();
                    $('#send_free_available_for_oblast_div').show();
                    $('#send_free_available_for_cities_div').hide();
                    break;
                default:
                    $('#send_free_available_for_send_free_id_div').hide();
                    $('#send_free_available_for_oblast_div').hide();
                    $('#send_free_available_for_cities_div').hide();
                    break;
            }
        }
        hideAllsend_free();
        $('#send_free_available_for').change(function(){
            switch ($(this).val()) {
                case 'country':
                    hideAllsend_free();
                    break;
                case 'city':
                    hideAllsend_free();
                    $('#send_free_available_for_send_free_id_div').show();
                    break;
                case 'cities':
                    hideAllsend_free();
                    $('#send_free_available_for_cities_div').show();
                    break;
                case 'area':
                    hideAllsend_free();
                    $('#send_free_available_for_oblast_div').show();
                    break;
                default:
                    hideAllsend_free();
                    break;
            }
        });
        // Add tags
        function isNullOrWhitespace( input ) {
            if (typeof input === 'undefined' || input == null) return true;
            return input.replace(/\s/g, '').length < 1;
        }
        function removeTag(item){
            // Remove tag from products_tags table by ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.delete-products-tags') }}",
                method: 'post',
                data: {
                    name: $('span:first', item.parentElement).html(),
                    product_id: '{{ $product->id }}'
                },
                success: function(result){
                    if (result === 'Yes'){
                        item.parentElement.remove();
                    }
                }
            });
        };
        $('#btn_add_tag').click(function(e){
            e.preventDefault();
            const divTags = document.getElementById('div_tags');
            const tagAdd = document.getElementById('tag_add');
            if (!isNullOrWhitespace(tagAdd.value)){
                divTags.innerHTML += '<p><span class="label label-success">'+tagAdd.value+'</span><input type="hidden" name="tags[]" value="'+tagAdd.value+'"> <span onclick="removeTag(this);" style="color:red;cursor:pointer;">Изтрий</span></p>';
                tagAdd.value = '';
            }
        });

        // Choose send_from_id
        $('#btn_send_from_id').click(function(){
            city_btn_click = 1;
            $('#table_city tr').each(function(){
                $(this).removeClass('selected_tr');
            });
        });
        $('#btn_send_free_id').click(function(){
            city_btn_click = 2;
            $('#table_city tr').each(function(){
                $(this).removeClass('selected_tr');
            });
        });
        $('#btn_select_city').click(function(){
            if (city_btn_click == 1){
                $('#send_from_id').val(('tr', $('.selected_tr')).find("td:nth-child(1)").html());
                if (('tr', $('.selected_tr')).find("td:nth-child(2)").html() == ('tr', $('.selected_tr')).find("td:nth-child(3)").html()){
                    $('#send_from_id_txt').val(('tr', $('.selected_tr')).find("td:nth-child(2)").html());
                }else{
                    $('#send_from_id_txt').val(('tr', $('.selected_tr')).find("td:nth-child(2)").html() + ' - ' + ('tr', $('.selected_tr')).find("td:nth-child(3)").html());
                }
            }
            if (city_btn_click == 2){
                $('#send_free_id').val(('tr', $('.selected_tr')).find("td:nth-child(1)").html());
                if (('tr', $('.selected_tr')).find("td:nth-child(2)").html() == ('tr', $('.selected_tr')).find("td:nth-child(3)").html()){
                    $('#send_free_id_txt').val(('tr', $('.selected_tr')).find("td:nth-child(2)").html());
                }else{
                    $('#send_free_id_txt').val(('tr', $('.selected_tr')).find("td:nth-child(2)").html() + ' - ' + ('tr', $('.selected_tr')).find("td:nth-child(3)").html());
                }
            }
            city_btn_click = 0;
        });
        $('#btn_activate').click(function(e){
            var currentdate = new Date();
            var currdate = currentdate.getDate() + "." + (currentdate.getMonth()+1) + "." + currentdate.getFullYear();
            $("#active_at").val(currdate);
            $("#status").val('active');
        });
    </script>
@stop
