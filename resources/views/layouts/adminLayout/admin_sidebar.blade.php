<?php use App\Category; ?>
<?php use App\Holiday; ?>
<?php use App\Tag; ?>
<?php use App\Product; ?>
<?php use App\Speditor; ?>
<?php use App\City; ?>
<?php use App\Order; ?>
<?php use App\Reklama; ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="{{ route('admin.dashboard') }}" class="visible-phone"><i class="icon icon-home"></i> Панел Управление</a>
    <ul>
      <li class="active"><a href="{{ route('admin.dashboard') }}"><i class="icon icon-home"></i> <span>Панел Управление</span></a> </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Продукти</span> <span class="label label-important">{{ Product::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-product') }}">Добави продукт</a></li>
          <li><a href="{{ route('admin.view-products') }}">Всички продукти</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Група Празници</span> <span class="label label-important">{{ Holiday::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-holiday') }}">Добави група празник</a></li>
          <li><a href="{{ route('admin.view-holidays') }}">Всички групи празници</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Категории обяви</span> <span class="label label-important">{{ Category::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-category') }}">Добави категория</a></li>
          <li><a href="{{ route('admin.view-categories') }}">Всички категории</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Етикети</span> <span class="label label-important">{{ Tag::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-tag') }}">Добави етикет</a></li>
          <li><a href="{{ route('admin.view-tags') }}">Всички етикети</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Доставчици</span> <span class="label label-important">{{ Speditor::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-speditor') }}">Добави доставчик</a></li>
          <li><a href="{{ route('admin.view-speditors') }}">Всички доставчици</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Населени места</span> <span class="label label-important">{{ City::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-city') }}">Добави населено място</a></li>
          <li><a href="{{ route('admin.view-cities') }}">Всички населени места</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Търговци</span></a>
        <ul>
          <li><a href="{{ route('admin.add-firm') }}">Добави търговец</a></li>
          <li><a href="{{ route('admin.view-firms') }}">Всички търговци</a></li>
          <li><a href="{{ route('admin.view-payments') }}">Всички плащания</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Клиенти</span></a>
        <ul>
          <li><a href="{{ route('admin.add-user') }}">Добави клиент</a></li>
          <li><a href="{{ route('admin.view-users') }}">Всички клиенти</a></li>
        </ul>
      </li>
      <li><a href="{{ route('admin.view-orders') }}"><i class="icon icon-th-list"></i> <span>Заявки</span> <span class="label label-important">{{ Order::count() }}</span></a></li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Реклама</span> <span class="label label-important">{{ Reklama::count() }}</span></a>
        <ul>
          <li><a href="{{ route('admin.add-reklama') }}">Добави реклама</a></li>
          <li><a href="{{ route('admin.view-reklami') }}">Всички реклами</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Страници</span> </a>
        <ul>
          <li><a href="{{ route('admin.edit-obshti-uslovia') }}">Общи условия</a></li>
          <li><a href="{{ route('admin.edit-politika') }}">Политика за лични данни</a></li>
        </ul>
      </li>
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Настройки</span> </a>
        <ul>
          <li><a href="{{ route('admin.edit-landing-page') }}">Начална страница</a></li>
          <li><a href="{{ route('admin.edit-price-page') }}">Цени пакети</a></li>
          <li><a href="{{ route('admin.edit-payment-packages') }}">Платежни методи</a></li>
          <li><a href="{{ route('admin.edit-maintenance-page') }}">Режим поддръжка</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <!--sidebar-menu-->
