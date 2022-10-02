@extends('layouts.app')
@section('title','Agent-Dashboard')

@push('css')

 


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item">Rack Bill Collection</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">

            @foreach($racks as $shop_rack)
               
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('agent.rack.bill_collection.rack_details', [Crypt::encrypt($shop_rack->rack_code)]) }}">
                        <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    {{ number_format($shop_rack->total_due,2) }}
                                    <small class="m-0 l-h-n" style="font-weight: bold; text-transform:uppercase"> {{ $shop_rack->rack_code }} ( {{ $shop_rack->shop_name }} )</small>
                                </h3>
                            </div>
                            <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                        </a>
                    </div>       
            @endforeach

        </div>
        




    </main>
@endsection

@push('js')






@endpush
