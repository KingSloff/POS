@inject('services', 'App\Services')

<tr>
    <td>{{$sale->created_at->timezone(auth()->user()->timezone)}}</td>
    <td>{{$services->displayCurrency($sale->price)}}</td>
    <td>{{$sale->amount}}</td>
    <td>{{$services->displayCurrency($sale->cpu)}}</td>
    <td>{{$services->displayCurrency($sale->total)}}</td>
    <td>{{$services->displayPercentage($sale->profit_percentage)}}</td>
</tr>