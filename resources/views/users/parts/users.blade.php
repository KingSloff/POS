<div class="table-responsive">
    <table class="table table-striped">
        <colgroup>
            <col span="1" style="width: 10%;">
            <col span="1" style="width: 90%;">
        </colgroup>
        <thead>
        <tr>
            <td><strong>User</strong></td> <td><strong>Name</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            @include('users.parts.user')
        @endforeach
        </tbody>
    </table>
</div>