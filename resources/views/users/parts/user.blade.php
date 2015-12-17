@inject('services', 'App\Services')

<tr>
    <td><a href="{{route('user.show', $user)}}">{{$user->id}}</a></td>
    <td>{{$user->name}}</td>
    <td>{{$services->displayCurrency($user->balance)}}</td>
</tr>