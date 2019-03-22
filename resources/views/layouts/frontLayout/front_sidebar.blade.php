<?php use App\Category; ?>
<?php use App\Product; ?>
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
                @php
                    $categories_parent = Category::where(['parent_id'=>$category->id])->get();
                    $categories_in[] = $category->id;
                    foreach ($categories_parent as $category_parent) {
                        $categories_in[] = $category_parent->id;
                    }
                    $products_count = Product::whereIn('category_id', $categories_in)->count();
                @endphp
                <a href="{{ route('products', ['category_id'=>$category->id]) }}"><i class="{{ $category->icon }}"></i>{{ $category->name }} <span class="category-counter">({{ $products_count }})</span></a>
            </li>
            @php
                $categories_in = null;
            @endphp
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
