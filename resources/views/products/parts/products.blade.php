<div class="table-responsive">
    <table class="table table-striped">
        <colgroup>
            <col span="1" style="width: 10%;">
            <col span="1" style="width: 80%;">
            <col span="1" style="width: 10%;">
        </colgroup>
        <thead>
        <tr>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('id', 'Product') !!}</strong></td>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('name') !!}</strong></td>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('in_stock', 'Stock') !!}</strong></td>
        </tr>
        </thead>
        <tbody>
        @each('products.parts.product', $products, 'product')
        </tbody>
    </table>
</div>