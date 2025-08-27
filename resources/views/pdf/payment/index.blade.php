@extends('layouts.pdf')

@section('content')
    <table>
        <thead>
            <tr>
                <th>DATE</th>
                <th>NUMBER</th>
                <th>CONTACT</th>
                <th>MODE</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{date_format(date_create($payment->date), 'D dS M Y')}}</td>
                <td>{{$payment->number}}</td>
                <td>{{$payment->contact->name??''}}</td>
                <td>{{$payment->mode}}</td>
                <td>{{$company->country->swift_code.' '.number_format($payment->balance,2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection