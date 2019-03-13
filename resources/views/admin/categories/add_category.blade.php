@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-categories') }}">Категории обяви</a> <a href="{{ route('admin.add-category') }}">Добави категория</a> </div>
      <h1>Категории обяви</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Добави Категория</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.add-category') }}" name="add_category" id="add_category" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Категория</label>
                  <div class="controls">
                    <input type="text" name="category_name" id="category_name">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Родителска категория</label>
                    <div class="controls">
                        <select name="parent_id" id="parent_id" style="width:314px;">
                            <option value="0">Без родителска категория</option>
                            @foreach ($levels as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Описание</label>
                  <div class="controls">
                    <textarea name="category_description" id="category_description"></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">URL</label>
                  <div class="controls">
                    <input type="text" name="category_url" id="category_url">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Добави категорията" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
