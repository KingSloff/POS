<div class="table-responsive">
    <table class="table table-striped">
        <colgroup>
            <col span="1" style="width: 10%;">
            <col span="1" style="width: 80%;">
            <col span="1" style="width: 10%;">
        </colgroup>
        <thead>
        <tr>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('id', 'User') !!}</strong></td>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('name') !!}</strong></td>
            <td><strong>{!! \App\Traits\SortableTrait::link_to_sorting_action('balance') !!}</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            @include('users.parts.user')
        @endforeach
        </tbody>
    </table>
</div>