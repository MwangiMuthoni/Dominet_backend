@extends('layouts.pdf')
@section('content')

<div class="w-100">
        @if($payment->contact)
        <table style="margin-top:55px;">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{$payment->contact->name}}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{$payment->contact->phone}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$payment->contact->email}}</td>
                </tr>
            </tbody>
        </table>
        @endif

        <table style="margin-top: 30px;">
            <tbody>
                <tr>
                    <th>Reference number</th>
                    <td>{{$payment->reference_number}}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{date_format(date_create($payment->date),'D dS M Y')}}</td>
                </tr>

                <tr>
                    <th>Mode</th>
                    <td>{{$payment->mode??''}}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>{{$company->country->swift_code.' '.number_format($payment->amount??'',2)}}</td>
                </tr>
                <tr>
                    <th>Notes</th>
                    <td>{{$payment->notes??''}}</td>
                </tr>
            </tbody>
        </table>
</div>

@endsection
