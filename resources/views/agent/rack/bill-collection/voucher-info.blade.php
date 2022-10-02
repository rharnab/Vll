@extends('layouts.app')
@section('title','Voucher Info')

@section('content')

<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Voucher Information</li>
    </ol>



                 <div class="row">
        <div class="col-xl-6 col-md-6 ">
           <div id="panel-7" class="panel">
                                <div class="panel-container show">
                                    <div class="panel-content">
                                        <div class="panel-tag">
                                          Rack Bill Voucher Generate Successfully
                                        </div>
                                        <div class="frame-wrap">
                                            <table class="table table-sm table-bordered m-0">
                                                
                                                <tbody>
                                                    <tr>
                                                        <td>Shop Name</td>
                                                        <td>{{ $voucher_info->shop_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agent Name</td>
                                                        <td>{{ $voucher_info->agent_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rack Code</td>
                                                        <td>{{ $voucher_info->rack_code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Socks Unit</td>
                                                        <td>{{ $voucher_info->socks_pair }} Pair</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Bill</td>
                                                        <td>{{ number_format($voucher_info->sale_amount,2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shop Commission</td>
                                                        <td>{{ number_format($voucher_info->shop_commission,2) }} ({{ $voucher_info->shop_commission_parcent  }}%)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agent Commission</td>
                                                        <td>{{ number_format($voucher_info->agent_commission,2) }} ({{ $voucher_info->agent_commission_parcent  }}%)</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <a href="{{ asset('voucher/shop/rack-bill-voucher/'.$voucher_info->shocks_bill_no) }}" download class="btn btn-success btn-block btn-sm">Voucher Download</a>
                                                        </td>
                                                    </tr>

                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
    </div>

    


</main>

@endsection