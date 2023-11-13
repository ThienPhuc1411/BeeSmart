@extends('admin.layout')
<form action="{{ route('vnpay') }}" method="post">
    @csrf
    <input type="hidden" name="MaDH" value="opisduayfidsa">
    <input type="hidden" name="order_desc" value="thanh toán hóa đơn">
    <input type="hidden" name="order_type" value="bill payment">
    <input type="hidden" name="total" value="300000">
    <input type="hidden" name="language" value="vn">
    <input type="hidden" name="bank_code" value="NCB">
    <button class="btn btn-default" type="submit" name="redirect">Thanh toán VNPAY</button>
</form>
@if (session('msg'))
    {{-- <a href="#" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                    </a> --}}
    {{-- <div class="alert alert-success">{{ session('msg') }}</div> --}}
@endif
