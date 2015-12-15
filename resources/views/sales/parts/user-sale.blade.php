@inject('services', 'App\Services')

<tr>
    <td>{{$sale->created_at}}</td>
    <td>{{$sale->product->name}}</td>
    <td>{{$services->displayCurrency($sale->price)}}</td>
    <td>{{$sale->amount}}</td>
    <td>{{$services->displayCurrency($sale->cpu)}}</td>
    <td>{{$services->displayCurrency($sale->total())}}</td>
</tr>