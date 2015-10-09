<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><strong>Ordered</strong></td>
            <td><strong>Amount</strong></td>
            <td><strong>Cost</strong></td>
            <td><strong>Complete</strong></td>
            <td><strong>Edit</strong></td>
            <td><strong>Delete</strong></td>
        </tr>
        </thead>
        <tbody>
        @each('orders.parts.order', $product->orders()->get(), 'order')
        </tbody>
    </table>
</div>