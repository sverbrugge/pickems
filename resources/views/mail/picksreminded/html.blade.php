@switch($user->locale)
    @case('nl')
<p>Hallo <strong>{{ $user->name }}</strong>,</p>

<p>Vergeet je niet om de top 10 voor de <strong>{{ $race->name }}</strong> door te geven?</p>

<p>Je hebt nog {{ $race->weekend_start->diffInHours() }} uur om dit te doen!</p>
    @break

    @case('en')
    @default
<p>Hi <strong>{{ $user->name }}</strong>,</p>

<p>This is a friendly reminder that you haven't picked yet for the <strong>{{ $race->name }}</strong>.</p>

<p>You have less then {{ $race->weekend_start->diffInHours() }} hours to do so!</p>
    @break
@endswitch
