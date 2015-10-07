<tr>
    <td>{{$stock->created_at}}</td>
    <td>{{$stock->amount}}</td>
    <td>{{$stock->in_stock}}</td>
    <td>{{$stock->cost}}</td>
    <td>{{$stock->prettyCpu()}}</td>
    <td>{{$stock->prettyProfitPercentage()}}</td>
    <td>
        <a href="{{route('product.stock.edit', ['product' => $stock->product, 'stock' => $stock])}}" class="btn btn-success">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>
    </td>
    <td>
        {!! Form::open(['route' => ['product.stock.destroy', $stock->product, $stock], 'method' => 'delete']) !!}
        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
        {!! Form::close() !!}
    </td>
</tr>