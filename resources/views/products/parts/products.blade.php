<div class="table-responsive">
    <table class="table table-striped">
        <colgroup>
            <col span="1" style="width: 10%;">
            <col span="1" style="width: 90%;">
        </colgroup>
        <thead>
        <tr>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('id', 'Product') !!}</strong></td>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('name') !!}</strong></td>
        </tr>
        </thead>
        <tbody>
        @each('products.parts.product', $products, 'product')
        </tbody>
    </table>
</div>