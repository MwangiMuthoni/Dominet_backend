@extends('layouts.pdf')
@section('content')

<div class="w-100">
    <div class="w-50">
        @if($bill->contact)
        <table style="margin-top:55px;">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{$bill->contact->name}}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{$bill->contact->phone}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$bill->contact->email}}</td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>
    <div class="w-50">
    <h4 class="document-number">{{$bill->number}}</h4>
        <table>
            <tbody>
                <tr>
                    <th>Date</th>
                    <td>{{date_format(date_create($bill->date),'D dS M Y')}}</td>
                </tr>
                <tr>
                    <th>Due date</th>
                    <td>{{date_format(date_create($bill->due_date),'D dS M Y')}}</td>
                </tr>
                <tr>
                    <th>Terms</th>
                    <td>{{$bill->terms}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{$bill->status??''}}</td>
                </tr>

                <tr>
                    <th>Order number</th>
                    <td>{{$bill->order_number??''}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="w-100">
    <table>
        <thead>
            <tr>
                <th style="width:250px">Narrative</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Disc</th>
                <th>Tax</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->items as $item)
            <tr>
                <td>{{$item->description}}</td>
                <td>{{number_format($item->unit,2)}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$company->country->swift_code.' '.number_format($item->discount,2)}}</td>
                <td>{{$company->country->swift_code.' '.number_format($item->tax_amount,2)}}</td>
                <td>{{$company->country->swift_code.' '.number_format($item->amount,2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="w-100">
    <div class="w-50"></div>
    <div class="w-50">
        <table>
            <tbody>
                <tr>
                    <th>Subtotal</th>
                    <td>{{$company->country->swift_code.' '.number_format($bill->subtotal,2)}}</td>
                </tr>
                <tr>
                    <th>Discount</th>
                    <td>{{$company->country->swift_code.' '.number_format($bill->discount,2)}}</td>
                </tr>
                <tr>
                    <th>Tax</th>
                    <td>{{$company->country->swift_code.' '.number_format($bill->tax,2)}}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>{{$company->country->swift_code.' '.number_format($bill->total,2)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
