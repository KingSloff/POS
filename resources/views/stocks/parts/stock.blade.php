@inject('services', 'App\Services')

<tr>
    <td>{{$stock->created_at->timezone(auth()->user()->timezone)}}</td>
    <td>{{$stock->amount}}</td>
    <td>{{$stock->in_stock}}</td>
    <td>{{$services->displayCurrency($stock->cost)}}</td>
    <td>{{$services->displayCurrency($stock->cpu())}}</td>
    <td>{{$services->displayPercentage($stock->profitPercentage())}}</td>
    <td>
        <a href="{{route('product.stock.edit', ['product' => $stock->product, 'stock' => $stock])}}" class="btn btn-success">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>
    </td>
    <td>
        {{ Form::open(['route' => ['product.stock.destroy', $stock->product, $stock], 'method' => 'delete']) }}
        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
        {{ Form::close() }}
    </td>
</tr>