<div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    <label for="email">Email</label>
    {{ Form::email('email', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    <label for="balance">Balance</label>
    {{ Form::text('balance', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    <label for="password">Password</label>
    {{ Form::password('password', ['class' => 'form-control']) }}
</div>

<div class="form-group">
    <label for="password_confirmation">Confirm Password</label>
    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
</div>