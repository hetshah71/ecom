<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Latest Products
            </h2>
        </div>
        <div class="row">
            @foreach($product as $products)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box">

                    <div class="img-box">
                        <img src="{{ asset('storage/'. $products->image ) }}" alt="">
                    </div>
                    <div class="detail-box">
                        <h6>{{$products->title}}</h6>
                        <h6>Price<span>₹{{$products->price}}</span></h6>
                    </div>
                    <div style="padding: 15px;">
                        <a href="{{url('product_details',$products->slug)}}" class="btn btn-danger">Details</a>
                        <button class="btn btn-success add-to-cart" data-product-id="{{$products->id}}">Add to Cart</button>
                        <div class="mt-2 cart-message-small"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>