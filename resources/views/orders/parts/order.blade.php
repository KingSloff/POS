@inject('services', 'App\Services')

<tr>
    <td>{{$order->created_at->timezone(auth()->user()->timezone)}}</td>
    <td>{{$order->amount}}</td>
    <td>{{$services->displayCurrency($order->cost)}}</td>
    <td>
        {{ Form::open(['route' => ['product.order.complete', $order->product, $order]]) }}
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span></button>
        {{ Form::close() }}
    </td>
    <td>
        <a href="{{route('product.order.edit', ['product' => $order->product, 'order' => $order])}}" class="btn btn-success">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>
    </td>
    <td>
        {{ Form::open(['route' => ['product.order.destroy', $order->product, $order], 'method' => 'delete']) }}
        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
        {{ Form::close() }}
    </td>
</tr>