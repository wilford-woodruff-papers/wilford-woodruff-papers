<div>
    <table>
        <thead>
            <tr>
                <th></th>
                @foreach($statuses as $status)
                    <th>{{ $status }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    @foreach($statuses as $status)
                        <td>{{ Number::format($stats[$type->name][$status]) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot></tfoot>
    </table>
</div>
