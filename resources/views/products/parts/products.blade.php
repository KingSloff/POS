<table class="table table-striped">
    <thead>
    <tr>
        <td>Product</td> <td>Name</td>
    </tr>
    </thead>
    <tbody>
    @each('products.parts.product', $products, 'product')
    </tbody>
</table>