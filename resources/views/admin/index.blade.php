@extends('admin.layout')
<form action="{{route('vnpay')}}" method="post">
    @csrf
    <input type="hidden" name="order_id" value="1231435">
    <input type="hidden" name="order_desc" value="thanh toán hóa đơn">
    <input type="hidden" name="order_type" value="bill payment">
    <input type="hidden" name="amount" value="300000">
    <input type="hidden" name="language" value="vn">
    <input type="hidden" name="bank_code" value="NCB">
    <button class="btn btn-default" type="submit" name="redirect">Thanh toán VNPAY</button>
</form>
