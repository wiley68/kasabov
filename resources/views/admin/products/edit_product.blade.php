<?php use App\Category; ?>
<?php use App\Tag; ?>
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
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-product', ['id'=>$product->id]) }}"
                name="edit_product" id="edit_product" novalidate="novalidate">
                @csrf
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
                                <label class="control-label">Количество</label>
                                <div class="controls">
                                    <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Цена *</label>
                                <div class="controls">
                                    <input type="number" name="price" id="price" value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Снимка</label>
                                <div class="controls">
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" id="current_image" value="{{ $product->image }}">
                                    @if (!empty($product->image))
                                        <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}"></a> | <a onclick="deleteProductImage('{{ route('admin.delete-product-image', ['id' => $product->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Основен цвят</label>
                                <div class="controls">
                                    <input type="color" id="first_color" name="first_color" value="{{ $product->first_color }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Втори цвят</label>
                                <div class="controls">
                                    <input type="color" id="second_color" name="second_color" value="{{ $product->second_color }}">
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
                                <label class="control-label">Пол</label>
                                <div class="controls">
                                    <select name="pol" id="pol" style="width:314px;">
                                        <option value="any" @if ($product->pol === 'any') selected @endif>Без значение</option>
                                        <option value="man" @if ($product->pol === 'man') selected @endif>За мъже</option>
                                        <option value="woman" @if ($product->pol === 'woman') selected @endif>За жени</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Състояние</label>
                                <div class="controls">
                                    <select name="condition" id="condition" style="width:314px;">
                                        <option value="new" @if ($product->condition === 'new') selected @endif>Нов</option>
                                        <option value="old" @if ($product->condition === 'old') selected @endif>Употребяван</option>
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
                                <label class="control-label">Изпраща се от:</label>
                                <div class="controls">
                                    <select name="send_from_id" id="send_from_id" style="width:314px;">
                                        <option value="0" selected>Няма посочен</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Цена за изпращане</label>
                                <div class="controls">
                                    <input type="number" name="price_send" id="price_send" value="{{ $product->price_send }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Безплатна доставка</label>
                                <div class="controls">
                                    <select name="send_free" id="send_free" style="width:314px;">
                                        <option value=1 @if ($product->send_free === 1) selected @endif>Не</option>
                                        <option value=0 @if ($product->send_free === 0) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Важи за:</label>
                                <div class="controls">
                                    <select name="send_free_id" id="send_free_id" style="width:314px;">
                                        <option value="0" selected>Няма посочен</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Доставя за:</label>
                                <div class="controls">
                                    <select name="available_for" id="available_for" style="width:314px;">
                                        <option value="country" @if ($product->available_for === 'country') selected @endif>Цялата страна</option>
                                        <option value="city" @if ($product->available_for === 'city') selected @endif>Населено място</option>
                                        <option value="cities" @if ($product->available_for === 'cities') selected @endif>Населени места</option>
                                        <option value="area" @if ($product->available_for === 'area') selected @endif>Област</option>
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
                                <textarea name="description" id="description" class="textarea_editor span12" rows="30">{!! $product->description !!}</textarea>
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
@endsection

@section('scripts')
    <script>
	    $('.textarea_editor').wysihtml5();
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
    </script>
@stop
