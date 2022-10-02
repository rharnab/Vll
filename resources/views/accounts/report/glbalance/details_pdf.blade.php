@extends('layouts.app')
@section('title','Commission')

@push('css')

<style>

    .list_style {
        list-style: none;
    }

</style>

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">



<div class="row">
    <div class="col-md-6">
    <h2 class="text-left font-weight-bold p-2">ASSET BALANCE LIST</h2>
    <ul class="list_style">
       <li> <span> <i class="fas fa-bars"></i></span> Level 1</li>
       <li> Level 1
            <ul class="list_style">
                <li>level 2 </li>
                <li>level 3
                    <ul class="list_style">
                        <li> Level 4</li>
                         <li>Level 4 
                             <ul class="list_style">
                                 <li>Level 5</li>
                                 <li>Level 5 
                                     <ul class="list_style">
                                         <li>Level 6</li>
                                         <li>Level 6
                                             <ul class="list_style">
                                                 <li> Level 7</li>
                                                 <li> Level 7</li>
                                                 <li> Level 7</li>
                                             </ul>
                                         </li>
                                    </ul>
                                 </li>
                             </ul>
                         </li>
                    </ul>    
                </li>
            </ul>   
        </li>
   </ul>

    </div>
</div>


  








</main>
@endsection

@push('js')



<script>


</script>




@endpush