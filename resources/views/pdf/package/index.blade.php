@extends('layouts.pdf')

@section('content')
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
                <td>{{$company->country->swift_code.' '.number_format($package->price,2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection