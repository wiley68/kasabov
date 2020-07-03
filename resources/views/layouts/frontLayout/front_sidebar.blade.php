<?php

use App\Category; ?>
<?php

use App\Holiday; ?>
<?php

use App\Product; ?>
<?php

use App\Reklama; ?>
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
        <div><a href="#"><span id="minimize-button" style="float:right;"><h5 class="switch-icons" >-</h5><span></a></div>
        <h4 class="widget-title">Филтър резултати</h4>
        <div class="add-box toggle-visible">
            <form enctype="multipart/form-data" action="{{ route('products') }}" method="post" name="filter_products" id="filter_products" novalidate="novalidate">
                @csrf
                <ul class="list-group list-group-flush">
                    <!-- Categories filter -->
                    <p style="font-weight:bold;font-size:120%;">Категории</p>
                    <div style="padding-bottom:10px;"></div>
                    @foreach ($categories as $category)
                    <label><input type="checkbox" @if(request()->has('category_id') AND in_array($category->id, request('category_id'))) checked @endif name="category_id[]" value="{{ $category->id }}">&nbsp;{{ $category->name }}</label>
                    @endforeach
                    <div style="padding-bottom:10px;"></div>
                    <!-- Price filter -->
                    @php
                    if(request()->has('min_price')){
                    $min_price = request('min_price');
                    }else{
                    $min_price = 0;
                    }
                    if(request()->has('max_price')){
                    $max_price = request('max_price');
                    }else{
                    $max_price = 0;
                    }
                    @endphp
                    <p>Мин. цена: 0 - {{ number_format($max_price_filter, 2, '.', '') }}{{ Config::get('settings.currency') }}</p>
                    <p>(<span id="min_price_current">{{ number_format($min_price, 2, '.', '') }} {{ Config::get('settings.currency') }}</span>)</p>
                    <input id="min_price" name="min_price" type="range" min="0" max="{{ $max_price_filter }}" value="{{ $min_price }}">
                    <p>Макс. цена: 0 - {{ number_format($max_price_filter, 2, '.', '') }}{{ Config::get('settings.currency') }}</p>
                    <p>(<span id="max_price_current">{{ number_format($max_price, 2, '.', '') }} {{ Config::get('settings.currency') }}</span>)</p>
                    <input id="max_price" name="max_price" type="range" min="0" max="{{ $max_price_filter }}" value="{{ $max_price }}">
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="age">
                        <option value="0">Възрастова група - всички</option>
                        <option value="any" @if(request()->has('age') AND request('age') == 'any') selected @endif>Без значение</option>
                        <option value="child" @if(request()->has('age') AND request('age') == 'child') selected @endif>За деца</option>
                        <option value="adult" @if(request()->has('age') AND request('age') == 'adult') selected @endif>За възрастни</option>
                    </select>
                    <div style="padding-bottom:10px;"></div>
                    <select style="width:100%;" name="send_id">
                        <option value="0">Изпраща се с - всички</option>
                        @foreach ($speditors as $speditor)
                        <option value="{{ $speditor->id }}" @if(request()->has('send_id') AND request('send_id') == $speditor->id) selected @endif>{{ $speditor->name }}</option>
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
        <h4 class="widget-title">Реклама</h4>
        @php
        $reklami_small = Reklama::where([['status', '=', '1'],['image_small', '!=', '']])->get();
        switch(sizeof($reklami_small)){
            case 0:
                break;
            case 1:
                $reklami_small = $reklami_small->random(1);
                break;
            case 2:
                $reklami_small = $reklami_small->random(2);
                break;
            case 3:
                $reklami_small = $reklami_small->random(3);
                break;
            default:
                $reklami_small = $reklami_small->random(3);
        }
        @endphp
        @foreach ($reklami_small as $reklama)
        <div class="add-box">
            <h5>{{ $reklama->title }}</h5>
            <p>{{ $reklama->description }}</p>
            @php
            if(!empty($reklama->image_small)){
            $image_small = asset('/images/backend_images/reklama_small/'.$reklama->image_small);
            }else{
            $image_small = "";
            }
            @endphp
            @if ($image_small != "")
            @if ($reklama->url != "") <a target="_blank" href="{{ $reklama->url }}"> @endif <img class="img-fluid" src="{{ $image_small }}" alt="{{ $reklama->title }}"> @if ($reklama->url != "") </a> @endif
            @endif
        </div>
        @endforeach
    </div>
</aside>