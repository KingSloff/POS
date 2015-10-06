<tr>
    <td>{{$stock->created_at}}</td>
    <td>{{$stock->amount}}</td>
    <td>{{$stock->cost}}</td>
    <td>{{$stock->cpu()}}</td>
    <td>{{$stock->profitPercentage()}}</td>
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