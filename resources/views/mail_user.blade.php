<h1>Здравейте, {{ $user_name }}</h1>
<hr />
<p>Заявка №: {{ $order_id }}</p>
<p>Направена на: {{ $order_created_at }}</p>
<p>Продукт: {{ $product_name }}</p>
<p>Търговец: {{ $targovec_name }}</p>
<p>Съобщение: {!! $order_message !!}</p>
<hr />
Благодарим за вашето внимание! PartyBox.