<div class="col-md-12">
    <div id="panel-2" class="panel">
        <div class="panel-container show">
            <div class="panel-content">
                <div class="accordion accordion-outline">                      
                    
                        <div class="card">
                            <div class="card-header">
                                <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#2"  aria-expanded="true">
                                    
                                    <i class="fal fa-socks width-2 fs-xl"></i>
                                        Search Socks List
                                    <span class="ml-auto">
                                        <span class="collapsed-reveal">
                                            <i class="fal fa-minus fs-xl"></i>
                                        </span>
                                        <span class="collapsed-hidden">
                                            <i class="fal fa-plus fs-xl"></i>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div id="m" class="collapse show" data-parent="#2">
                                <div class="card-body">
                                    <div class="frame-wrap">
                                        <div class="demo">
                                            @if(count($socks) > 0) 
                                                @foreach($socks as $sock)
                                                    <div class="custom-control custom-checkbox single_checkbox">
                                                        <input type="checkbox" onclick="countTotalSoldoutSocks('{{ $sock->shocks_code}}')" class="select_items custom-control-input rack_single_shocks_{{  $sock->type_id }}" value="{{ $sock->shocks_code }}" id="{{ $sock->shocks_code }}">
                                                        <label  class="custom-control-label" for="{{ $sock->shocks_code}}">{{ $sock->shop_socks_code ?? $sock->printed_socks_code }} ({{  $sock->brand_name }})</label>
                                                    </div> 
                                                @endforeach
                                            @else 
                                                <div class="custom-control custom-checkbox">
                                                     <label  class="custom-control-label">Socks Not Found</label>
                                                </div> 
                                            @endif
                                                                                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                </div>
                </div>
            </div>
        </div>
    </div>