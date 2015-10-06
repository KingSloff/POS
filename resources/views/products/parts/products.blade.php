<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><strong>Product</strong></td> <td><strong>Name</strong></td>
        </tr>
        </thead>
        <tbody>
        @each('products.parts.product', $products, 'product')
        </tbody>
    </table>
</div>