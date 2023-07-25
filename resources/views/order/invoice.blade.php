<!DOCTYPE html>
<html>
<head>
    <title>Generate Invoice</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-70{
        width: 70%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:200px;
        height:60px;        
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">{{ $orderId }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">{{ date('D-m-Y H:i:S',time()) }}</span></p>
    </div>
    <div style="clear: both;margin-bottom:10px;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Cashier</th>
            <th class="w-50">Costumer</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <h2 class="text-center">{{ auth()->user()->name }}</h2>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <h2 class="text-center">{{ $costumer }}</h2>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-100">Payment Method</th>
        </tr>
        <tr>
            <td class="text-center"><h2> Cash</h2></td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <thead>
            <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Sub price</th>
                <th>Qty</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td style="width: 10px">{{ $i++ }}</td>
                <td>{{ $item['product_name'] }}</td>
                <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td>@if($item['discount'] > 0){{ $item['discount'] }}% @else - @endif</td>
                <td>Rp {{ number_format($item['total_price_product'], 0, ',', '.') }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>Rp {{ number_format($item['sub_total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <h2>Total</h2>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <h5>Rp {{ number_format($total, 0, ',', '.') }},-</h5>
                    </div>
                    <div style="padding: 10px">
                        <p>{!! DNS1D::getBarcodeHTML($ID, 'C39') !!}</p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>