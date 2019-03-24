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
                    <select style="width:100%;" name="first_color_filter">
                                <option value="0">Основен цвят - всички</option>
                                <option value="red">Червен</option>
                                <option value="yellow">Жълт</option>
                                <option value="green">Зелен</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="second_color_filter">
                                <option value="0">Втори цвят - всички</option>
                                <option value="red">Червен</option>
                                <option value="yellow">Жълт</option>
                                <option value="green">Зелен</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="age_filter">
                                <option value="0">Възрастова група - всички</option>
                                <option value="red">За деца</option>
                                <option value="yellow">За възрастни</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="pol_filter">
                                <option value="0">Пол - всички</option>
                                <option value="red">Мъж</option>
                                <option value="yellow">Жена</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="condition_filter">
                                <option value="0">Състояние - всички</option>
                                <option value="red">Нов</option>
                                <option value="yellow">Употребяван</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="send_id_filter">
                                <option value="0">Изпраща се с - всички</option>
                                @foreach ($speditors as $speditor)
                                    <option value="{{ $speditor->id }}">{{ $speditor->name }}</option>
                                @endforeach
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="send_free_filter">
                                <option value="0">Безплатна дост. - Да , Не</option>
                                <option value="red">Да</option>
                                <option value="yellow">Не</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="object_filter">
                                <option value="0">Може ли да се вземе от обект</option>
                                <option value="red">Да</option>
                                <option value="yellow">Не</option>
                            </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="send_free_filter">
                                <option value="0">Персонализиране - Да , Не</option>
                                <option value="red">Да</option>
                                <option value="yellow">Не</option>
                            </select>
                </ul>
                <div style="padding-bottom:10px;"></div>
                <input type="submit" value="Покажи резултата" class="btn btn-primary" />
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
