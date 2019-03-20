<?php use App\Category; ?>
<aside>
    <!-- Searcg Widget -->
    <div class="widget_search">
        <form role="search" id="search-form">
            <input type="search" class="form-control" autocomplete="off" name="s" placeholder="Търси..." id="search-input" value="">
            <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
        </form>
    </div>
    <!-- Categories Widget -->
    <div class="widget categories">
        <h4 class="widget-title">Всички категории</h4>
        <ul class="categories-list">
            @foreach ($categories as $category)
            <li>
                <a href="#"><i class="{{ $category->icon }}"></i>{{ $category->name }} <span class="category-counter">({{ Category::where(['parent_id'=>$category->id])->count() }})</span></a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="widget">
        <h4 class="widget-title">Advertisement</h4>
        <div class="add-box">
            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
        </div>
    </div>
</aside>
