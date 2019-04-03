<?php use App\Category; ?>
<?php use App\Holiday; ?>
<?php use App\Product; ?>
<aside>
    <!-- Searcg Widget -->
    <div class="widget_search">
        <form role="search" id="search-form">
            <input type="search" class="form-control" autocomplete="off" name="s" placeholder="Търси..." id="search-input" value="">
            <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
        </form>
    </div>

    <!-- All filters -->
    <div class="widget">
        <h4 class="widget-title">Филтър резултати</h4>
        <div class="add-box">
            <form enctype="multipart/form-data" action="{{ route('products') }}" method="post" name="filter_products" id="filter_products" novalidate="novalidate">
                @csrf
                <ul class="list-group list-group-flush">
                    <!-- Holidays filter -->
                    <p style="font-weight:bold;font-size:120%;">Празници</p>
                    <div style="padding-bottom:10px;"></div>
                    @foreach ($holidays as $holiday)
                        <label><input type="checkbox" @if(request()->has('holiday_id') AND in_array($holiday->id, request('holiday_id'))) checked @endif name="holiday_id[]" value="{{ $holiday->id }}">&nbsp;{{ $holiday->name }}</label>
                    @endforeach
                    <div style="padding-bottom:10px;"></div>
                    <!-- Categories filter -->
                    <p style="font-weight:bold;font-size:120%;">Категории</p>
                    <div style="padding-bottom:10px;"></div>
                    @foreach ($categories as $category)
                        <label><input type="checkbox" @if(request()->has('category_id') AND in_array($category->id, request('category_id'))) checked @endif name="category_id[]" value="{{ $category->id }}">&nbsp;{{ $category->name }}</label>
                    @endforeach
                    <div style="padding-bottom:10px;"></div>
                    <!-- Price filter -->
                    <p>Минимална цена: 0 - 20000</p>
                    <input type="range" min="0" max="20000" value="1000">
                    <p>Максимална цена: 0 - 20000</p>
                    <input type="range" min="0" max="20000" value="1000">
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="first_color">
                        <option value="0">Основен цвят - всички</option>
                        <option value="white" @if(request()->has('first_color') AND request('first_color') == 'white') selected @endif>Бял</option>
                        <option value="gray" @if(request()->has('first_color') AND request('first_color') == 'gray') selected @endif>Сив</option>
                        <option value="black" @if(request()->has('first_color') AND request('first_color') == 'black') selected @endif>Черен</option>
                        <option value="red" @if(request()->has('first_color') AND request('first_color') == 'red') selected @endif>Червен</option>
                        <option value="yellow" @if(request()->has('first_color') AND request('first_color') == 'yellow') selected @endif>Жълт</option>
                        <option value="green" @if(request()->has('first_color') AND request('first_color') == 'green') selected @endif>Зелен</option>
                        <option value="blue" @if(request()->has('first_color') AND request('first_color') == 'blue') selected @endif>Син</option>
                        <option value="brown" @if(request()->has('first_color') AND request('first_color') == 'brown') selected @endif>Кафяв</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="second_color">
                        <option value="0">Втори цвят - всички</option>
                        <option value="white" @if(request()->has('second_color') AND request('second_color') == 'white') selected @endif>Бял</option>
                        <option value="gray" @if(request()->has('second_color') AND request('second_color') == 'gray') selected @endif>Сив</option>
                        <option value="black" @if(request()->has('second_color') AND request('second_color') == 'black') selected @endif>Черен</option>
                        <option value="red" @if(request()->has('second_color') AND request('second_color') == 'red') selected @endif>Червен</option>
                        <option value="yellow" @if(request()->has('second_color') AND request('second_color') == 'yellow') selected @endif>Жълт</option>
                        <option value="green" @if(request()->has('second_color') AND request('second_color') == 'green') selected @endif>Зелен</option>
                        <option value="blue" @if(request()->has('second_color') AND request('second_color') == 'blue') selected @endif>Син</option>
                        <option value="brown" @if(request()->has('second_color') AND request('second_color') == 'brown') selected @endif>Кафяв</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="age">
                        <option value="0">Възрастова група - всички</option>
                        <option value="any" @if(request()->has('age') AND request('age') == 'any') selected @endif>Без значение</option>
                        <option value="child" @if(request()->has('age') AND request('age') == 'child') selected @endif>За деца</option>
                        <option value="adult" @if(request()->has('age') AND request('age') == 'adult') selected @endif>За възрастни</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="pol">
                        <option value="0">Пол - всички</option>
                        <option value="man" @if(request()->has('pol') AND request('pol') == 'man') selected @endif>Мъж</option>
                        <option value="woman" @if(request()->has('pol') AND request('pol') == 'woman') selected @endif>Жена</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="condition">
                        <option value="0">Състояние - всички</option>
                        <option value="new" @if(request()->has('condition') AND request('condition') == 'new') selected @endif>Нов</option>
                        <option value="old" @if(request()->has('condition') AND request('condition') == 'old') selected @endif>Употребяван</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="send_id_filter">
                        <option value="0">Изпраща се с - всички</option>
                        @foreach ($speditors as $speditor)
                        <option value="{{ $speditor->id }}">{{ $speditor->name }}</option>
                        @endforeach
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="send_free">
                        <option value=0>Безплатна дост. - Да , Не</option>
                        <option value=1 @if(request()->has('send_free') AND request('send_free') == 1) selected @endif>Да</option>
                        <option value=2 @if(request()->has('send_free') AND request('send_free') == 2) selected @endif>Не</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="object">
                        <option value=0>Може ли да се вземе от обект</option>
                        <option value=1 @if(request()->has('object') AND request('object') == 1) selected @endif>Да</option>
                        <option value=2 @if(request()->has('object') AND request('object') == 2) selected @endif>Не</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="personalize">
                        <option value=0>Персонализиране - Да , Не</option>
                        <option value=1 @if(request()->has('personalize') AND request('personalize') == 1) selected @endif>Да</option>
                        <option value=2 @if(request()->has('personalize') AND request('personalize') == 2) selected @endif>Не</option>
                    </select>
                </ul>
                <div style="padding-bottom:10px;"></div>
                <input type="submit" value="Покажи резултата" class="btn btn-primary" />
                <div style="padding-bottom:5px;"></div>
                <a href={{ route('products') }} class="btn btn-danger">Нулирай филтъра</a>
            </form>
        </div>
    </div>

    <div class="widget">
        <h4 class="widget-title">Advertisement</h4>
        <div class="add-box">
            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
        </div>
    </div>
</aside>
