@extends('admin.layout.index')
@section('title') Products @endsection

@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/css/ecommerce.css') }}" />
@endsection

@section('content')
<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Product Detail
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                </ul>
            </div>
        </div>
    </div>



    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <!-- View -->
                    <div class="body">
                        <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <!-- View -->
                                <div class="body">
                                
                                    <div class="row clearfix">

                                    <div class="preview col-lg-4 col-md-12">
                                        <div class="preview-pic tab-content">
                                        @forelse($productDetail->productImages as $key => $image)
                                            <div class="tab-pane {{($key==0) ? 'active' : ''}}" id="product_{{$key}}"><img src="{{$image->product_image}}" class="img-fluid"></div>
                                        @empty  
                                        @endforelse
                                        </div>

                                        <ul class="preview-thumbnail nav nav-tabs">
                                        @forelse($productDetail->productImages as $key => $image)
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product_{{$key}}"><img src="{{$image->product_image}}"></a></li>
                                        @empty  
                                        @endforelse
                                        </ul>
                                    </div>  

                                    <div class="details col-lg-8 col-md-12">
                                <h3 class="product-title">{{$productDetail->product_name}} ({{$productDetail->product_name_ar}})</h3>
                                <h4 class="price">Current Price: <span class="col-amber">${{$productDetail->price}}</span></h4>
                                @if(!empty($productDetail->flat_price))
                                <h4 class="price">Flat Price: <span class="col-amber">${{$productDetail->flat_price}}</span></h4>
                                <h4 class="price">Discount: <span class="col-amber">{{$productDetail->discount}}%</span></h4>
                                @endif
                                <h5 class="quantity">Quantity: <span class="col-amber">{{$productDetail->quantity}}</span></h5>
                                <div class="rating">

                                    <div class="stars">
                                        @for($i = 1; $i <= round($productDetail->total_rating); $i++)
                                            <span class="zmdi zmdi-star col-amber"></span>
                                        @endfor

                                        @if(round($productDetail->total_rating) < 5)
                                            @for($i = (5 - round($productDetail->total_rating)); $i >= 1; $i--)
                                                <span class="zmdi zmdi-star-outline"></span>
                                            @endfor
                                            
                                        @endif
                                        
                                        
                                    </div>
                                    <span class="m-l-10">{{$productDetail->total_review}} reviews</span>
                                </div>
                                <hr>
                                <p class="product-description">{{substr($productDetail->description, 0, 200)}}...</p>
                                <label class="custom-label">Category : {{$productDetail->category}}</label>
                                
                                @foreach($productDetail->productAttributes as $key => $attribute)
                                    
                                    <h5 class="sizes">{{$attribute->attribute_name}}:
                                    
                                    @foreach($attribute->productAttributeOption as $attrEx)
                                    <span class="size" title="small">{{$attrEx->option_name}}</span>
                                    @endforeach
                                    
                                @endforeach
                                
                                <!-- <h5 class="sizes">sizes:
                                    <span class="size" title="small">s</span>
                                    <span class="size" title="medium">m</span>
                                    <span class="size" title="large">l</span>
                                    <span class="size" title="xtra large">xl</span>
                                </h5> -->
                                <!-- <h5 class="colors">colors:
                                    <span class="color bg-amber not-available" title="Not In store"></span>
                                    <span class="color bg-green"></span>
                                    <span class="color bg-blue"></span>
                                </h5> -->
                                
                                
                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                           
                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="custom-label">Store Name : </label>
                                    <label class="custom-control">{{$productDetail->store_name}}</label>
                                </div>
                            </div>

                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="custom-label">Seller Name : </label>
                                    <label class="custom-control">{{$productDetail->seller_name}}</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="custom-label">is Return Allowed : </label>
                                    <label class="custom-control">{{($productDetail->is_return_allow) ? 'Yes' : 'No'}}</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End View -->
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <!-- View -->
                    <div class="body">
                    <h4>Description</h4> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="custom-control">{{$productDetail->description}} </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="custom-control">{{$productDetail->description_ar}} </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <!-- View -->
                    <div class="body">
                    <h4>Additional Info</h4> 
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="custom-control">{{$productDetail->add_info}} </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="custom-control">{{$productDetail->add_info_ar}} </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            

        </div>
        @include('admin.common.footer_detail')
    </div>

</section>
@endsection

@section('js')

@endsection