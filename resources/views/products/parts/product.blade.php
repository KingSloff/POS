@inject('services', 'App\Services')

<tr>
    <td><a href="{{route('product.show', $product)}}">{{$product->id}}</a></td>
    <td>{{$product->name}}</td>
    <td>{{$services->displayAmount($product->in_stock)}}</td>
    <td>{{$services->displayCurrency($product->profit)}}</td>
</tr>