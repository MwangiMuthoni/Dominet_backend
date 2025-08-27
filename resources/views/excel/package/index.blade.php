<table>
    <thead>
        <tr>
            <th>NAME</th>
            <th>TYPE</th>
            <th>PRICE</th>
        </tr>
    </thead>
    <tbody>
        @foreach($packages as $package)
        <tr>
            <td>{{$package->name??''}}</td>
            <td>{{$package->type}}</td>
            <td>{{$package->price}}</td>
        </tr>
        @endforeach
    </tbody>
</table>