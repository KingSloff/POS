<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><strong>Sold</strong></td>
            <td><strong>Product</strong></td>
            <td><strong>Price</strong></td>
            <td><strong>Amount</strong></td>
            <td><strong>Cost Per Unit</strong></td>
            <td><strong>Total</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($sales as $sale)
            @include('sales.parts.user-sale')
        @endforeach
        </tbody>
    </table>
</div>