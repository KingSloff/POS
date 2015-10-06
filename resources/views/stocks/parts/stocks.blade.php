<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><strong>Purchased</strong></td>
            <td><strong>Amount</strong></td>
            <td><strong>Cost</strong></td>
            <td><strong>Cost Per Unit</strong></td>
            <td><strong>Profit Percentage</strong></td>
            <td><strong>Edit</strong></td>
            <td><strong>Delete</strong></td>
        </tr>
        </thead>
        <tbody>
        @each('stocks.parts.stock', $product->stocks, 'stock')
        </tbody>
    </table>
</div>