<table class="table table-striped">
    <thead>
    <tr>
        <td>Purchased</td> <td>Amount</td> <td>Cost</td> <td>Cost Per Unit</td>
    </tr>
    </thead>
    <tbody>
    @each('stocks.parts.stock', $product->stocks, 'stock')
    </tbody>
</table>