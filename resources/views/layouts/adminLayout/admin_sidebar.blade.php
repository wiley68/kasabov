<?php use App\Category; ?>
<?php use App\Holiday; ?>
<?php use App\Tag; ?>
<?php use App\Product; ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="{{ route('admin.dashboard') }}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
      <li class="active"><a href="{{ route('admin.dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Продукти</span> <span class="label label-important">{{ Product::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-product') }}">Добави продукт</a></li>
          <li><a href="{{ route('admin.view-products') }}">Всички продукти</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Категории обяви</span> <span class="label label-important">{{ Category::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-category') }}">Добави категория</a></li>
          <li><a href="{{ route('admin.view-categories') }}">Всички категории</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Празници</span> <span class="label label-important">{{ Holiday::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-holiday') }}">Добави празник</a></li>
          <li><a href="{{ route('admin.view-holidays') }}">Всички празници</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Етикети</span> <span class="label label-important">{{ Tag::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-tag') }}">Добави етикет</a></li>
          <li><a href="{{ route('admin.view-tags') }}">Всички етикети</a></li>
        </ul>
      </li>
      <li class="content"> <span>Monthly Bandwidth Transfer</span>
        <div class="progress progress-mini progress-danger active progress-striped">
          <div style="width: 77%;" class="bar"></div>
        </div>
        <span class="percent">77%</span>
        <div class="stat">21419.94 / 14000 MB</div>
      </li>
      <li class="content"> <span>Disk Space Usage</span>
        <div class="progress progress-mini active progress-striped">
          <div style="width: 87%;" class="bar"></div>
        </div>
        <span class="percent">87%</span>
        <div class="stat">604.44 / 4000 MB</div>
      </li>
    </ul>
  </div>
  <!--sidebar-menu-->
