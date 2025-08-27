<table>
    <thead>
        <tr>
            <th>DATE</th>
            <th>NUMBER</th>
            <th>CONTACT</th>
            <th>TOTAL</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
        <tr>
            <td>{{date_format(date_create($bill->date), 'D dS M Y')}}</td>
            <td>{{$bill->number}}</td>
            <td>{{$bill->contact->name??''}}</td>
            <td>{{number_format($bill->total,2)}}</td>
            <td>{{$bill->status}}</td>
        </tr>
        @endforeach
    </tbody>
</table>