<h1> {{ $group->name }}</h1>

<div>
    <p>Hello {{ $user->first_name }} {{ $user->last_name }}</p>

    <p> New Group has been created {{ $group->name }}</p>
    <h3>Claim timeslot</h3>
    <div>
        <ul>
            @foreach ($timeslots as $timeslot)
                <li>
                    <h3>{{ $timeslot->date }}</h3>
                    <p>
                        <span>
                            {{ date_format(date_create($timeslot->start_time), 'H:i:s') }}
                            -
                            {{ date_format(date_create($timeslot->end_time), 'H:i:s') }}
                        </span>
                        <a
                            href="{{ URL::signedRoute('claimtimeslot', ['group' => $group->id, 'timeslot' => $timeslot->id, 'user' => $user->id], absolute: true) }}">
                            Claim
                        </a>
                    </p>
                <li>
            @endforeach
        </ul>
    </div>
</div>
