<?php use App\Product; ?>
<?php use App\User; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Start Content -->
<script type="text/javascript">
    function deletePayment(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрито плащането. Операцията е невъзвратима!",
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
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                <aside>
                    <div class="sidebar-box">
                        <div class="user">
                            <figure>
                                <img src="{{ asset('/images/backend_images/users/'.$user->image) }}" alt="">
                            </figure>
                            <div class="usercontent">
                                <h3>Здравейте {{ Auth::user()->name }}!</h3>
                                <h4>Търговец</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a href="{{ route('home-firm') }}">
                                                <i class="lni-dashboard"></i><span>Панел управление</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-settings') }}">
                                                <i class="lni-cog"></i><span>Настройки профил</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-adds') }}">
                                                <i class="lni-layers"></i><span>Моите оферти</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-orders') }}">
                                                <i class="lni-envelope"></i><span>Поръчки</span>
                                            </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('home-firm-payments') }}">
                                                <i class="lni-wallet"></i><span>Плащания</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-privacy') }}">
                                                <i class="lni-star"></i><span>Лични</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout-front-firm') }}">
                                                <i class="lni-enter"></i><span>Изход</span>
                                            </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Advertisement</h4>
                        <div class="add-box">
                            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
                        </div>
                    </div>
                </aside>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                @if (Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
                @endif
                <div class="page-content">
                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Моите плащания</h2>&nbsp;
                            <a class="btn btn-common" href="{{ route('home-firm-payment-new') }}" style="color:white;">Създай ново плащане</a>
                        </div>
                        <div class="dashboard-wrapper">
                            <table class="table table-responsive dashboardtable tablemyads">
                                <thead>
                                    <tr>
                                        <th>Плащане №</th>
                                        <th>Активирано на</th>
                                        <th>Състояние</th>
                                        <th>Тип плащане</th>
                                        <th>Относно</th>
                                        <th>Управление</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr data-category="active">
                                            <td data-title="Плащане №">{{ $payment->id }}</td>
                                            <td data-title="Активирано на">{{ date('d.m.Y', strtotime(date($payment->active_at))) }}</td>
                                            @php
                                            switch ($payment->status) {
                                                case 'active':
                                                    $payment_status = "Активно";
                                                    break;
                                                case 'pending':
                                                    $payment_status = "Изчаква плащане";
                                                    break;
                                                case 'expired':
                                                    $payment_status = "Изтекло";
                                                    break;
                                                default:
                                                    $payment_status = "Изчаква плащане";
                                                    break;
                                            }
                                            @endphp
                                            <td data-title="Състояние">{{ $payment_status }}</td>
                                            @php
                                            switch ($payment->payment) {
                                                case 'bank':
                                                    $payment_type = "Банка";
                                                    break;
                                                case 'sms':
                                                    $payment_type = "SMS";
                                                    break;
                                                case 'kurier':
                                                    $payment_type = "Наложен платеж";
                                                    break;
                                                default:
                                                    $payment_type = "Банка";
                                                    break;
                                            }
                                            @endphp
                                            <td data-title="Тип плащане">{{ $payment_type }}</td>
                                            @php
                                            switch ($payment->forthe) {
                                                case 'standart':
                                                    $payment_forthe = "Стандартно";
                                                    $payment_sum = "10.00";
                                                    break;
                                                case 'reklama1':
                                                    $payment_forthe = "Пакет 1 промо продукт";
                                                    $payment_sum = "20.00";
                                                    break;
                                                case 'reklama3':
                                                    $payment_forthe = "Пакет 3 промо продукта";
                                                    $payment_sum = "30.00";
                                                    break;
                                                default:
                                                    $payment_forthe = "Стандартно";
                                                    $payment_sum = "10.00";
                                                    break;
                                            }
                                            @endphp
                                            <td data-title="Относно">{{ $payment_forthe }}</td>
                                            <td data-title="Управление">
                                                <div class="btns-actions">
                                                    <a class="btn-action btn-view" target="_blank" href="" title="Покажи подробни данни за плащането"><i class="lni-eye"></i></a>
                                                    <a style="cursor:pointer;" class="btn-action btn-delete" onclick="deletePayment('{{ route('delete-firm-payment', ['id' => $payment->id]) }}');" title="Изтрий плащането"><i class="lni-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr />
                            <!-- Start Pagination -->
                            {{ $payments->links() }}
                            <!-- End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
