<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Lists</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000000;
            padding: 0.5em;
            height: 1rem;
        }

        .page-break {
            page-break-before: always;
        }

        .width-10 {
            width: 10%;
        }

        .width-20 {
            width: 20%;
        }

        .width-40 {
            width: 40%;
        }
    </style>
</head>

<body>

@inject('services', 'App\Services')

@foreach($usersTransactions as $username => $userTransactions)
    <h2>{{$username}}</h2>
    <table>
        <thead>
        <tr>
            <th class="width-40"><strong>Description</strong></th>
            <th class="width-20"><strong>Date</strong></th>
            <th class="width-10"><strong>Debit</strong></th>
            <th class="width-10"><strong>Credit</strong></th>
            <th class="width-10"><strong>Balance</strong></th>
            <th class="width-10"><strong>Signature</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php $count = 0; ?>
        @foreach($userTransactions as $userTransaction)
            <?php $count++; ?>
            <tr>
                <td>{{$userTransaction['description']}}</td>
                <td>{{$userTransaction['date']->timezone(auth()->user()->timezone)->toDateString()}}</td>

                @if(!empty($userTransaction['debit']))
                    <td>{{$services->displayAccountingAmount($userTransaction['debit'])}}</td>
                @else
                    <td></td>
                @endif

                @if(!empty($userTransaction['credit']))
                    <td>{{$services->displayAccountingAmount($userTransaction['credit'])}}</td>
                @else
                    <td></td>
                @endif

                <td>{{$services->displayAccountingAmount(-1 * $userTransaction['balance'])}}</td>
                <td></td>
            </tr>
        @endforeach
        @for($counter = $count; $count < 27; $count++)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div class="page-break"></div>
@endforeach

</body>
</html>

