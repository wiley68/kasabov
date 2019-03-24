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
            <ul class="list-group list-group-flush">
                <select style="width:100%;" name="holiday_filter">
                    <option value="0">Всички празници</option>
                    @foreach ($holidays as $holiday)
                        <option value="{{ $holiday->id }}">{{ $holiday->name }}</option>
                        @foreach (Holiday::where(['parent_id'=>$holiday->id])->get() as $item)
                            <option value="{{ $item->id }}">&nbsp;--&nbsp;{{ $item->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                <div style="padding-bottom:10px;"></div>
                <select style="width:100%;" name="category_filter">
                    <option value="0">Всички категории</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @foreach (Category::where(['parent_id'=>$category->id])->get() as $item)
                            <option value="{{ $item->id }}">&nbsp;--&nbsp;{{ $item->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                <div style="padding-bottom:10px;"></div>
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
        </div>
    </div>

    <div class="widget">
        <h4 class="widget-title">Advertisement</h4>
        <div class="add-box">
            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
        </div>
    </div>
</aside>
