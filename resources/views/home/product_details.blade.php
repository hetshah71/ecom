<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <style type="text/css">
        .div_center {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .detail-box {
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <!-- Product details Start -->
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Latest Products
                </h2>
            </div>
            <div class="row">

                <div class=" col-md-12 ">
                    <div class="box">

                        <div class="div_center">
                            <img width="400" src="{{ asset('storage/'. $data->image ) }}" alt="">
                        </div>
                        <div class="detail-box">
                            <h6>Product : {{$data->title}}</h6>
                            <h6>Price : <span>₹{{$data->price}}</span></h6>
                        </div>

                        <div class="detail-box">
                            <h6>category : {{$data->category}}</h6>
                            <h6>Available Quantity : <span>{{$data->quantity}}</span></h6>
                        </div>

                        <div class="detail-box">
                            
                             <p>description : {{$data->description}}</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>




    <!-- Product details end -->
    <!-- info section -->
    @include('home.footer')
    <!-- end info section -->


</body>

</html>