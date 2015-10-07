<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><strong>Sold</strong></td>
            <td><strong>Price</strong></td>
            <td><strong>Amount</strong></td>
            <td><strong>Cost Per Unit</strong></td>
            <td><strong>Total</strong></td>
            <td><strong>Profit Percentage</strong></td>
        </tr>
        </thead>
        <tbody>
        @each('sales.parts.sale', $product->sales, 'sale')
        </tbody>
    </table>
</div>