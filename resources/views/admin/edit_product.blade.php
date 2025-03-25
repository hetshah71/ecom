<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    @vite("resources/css/app.css")
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                @if(session()->has('success'))
                <div class="mb-6 relative p-4 rounded-md bg-green-100/10 border border-green-200/20 text-green-400">
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 opacity-50 hover:opacity-100 cursor-pointer text-green-400" data-dismiss="alert" aria-hidden="true">×</button>
                    {{session()->get('success')}}
                </div>
                @endif
                <div class="max-w-3xl mx-auto p-8 bg-black/20 rounded-lg shadow-lg">
                    <h1 class="text-white text-2xl font-semibold mb-8 text-center">Edit Product</h1>
                    <form action="{{url('/admin/update_product', $product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Title :</label>
                            <input class="w-full px-3 py-3 bg-white/5 border border-white/10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/25" type="text" name="title" placeholder="Write a title" required value="{{$product->title}}">
                        </div>
                        @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Description :</label>
                            <input class="w-full px-3 py-3 bg-white/5 border border-white/10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/25" type="text" name="description" placeholder="Write a description" required value="{{$product->description}}">
                        </div>
                        @error('description')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Price :</label>
                            <input class="w-full px-3 py-3 bg-white/5 border border-white/10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/25" type="number" name="price" placeholder="Write a price" required value="{{$product->price}}">
                        </div>
                        @error('price')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Quantity :</label>
                            <input class="w-full px-3 py-3 bg-white/5 border border-white/10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/25" type="number" min="0" name="qty" placeholder="Write a quantity" required value="{{$product->quantity}}">
                        </div>
                        @error('qty')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Category :</label>
                            <select class="w-full px-3 py-3 bg-white/5 border border-white/10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/25 cursor-pointer" name="category" required>
                                <option value="{{$product->category}}" selected>{{$product->category}}</option>
                                @foreach($category as $category)
                                @if($category->category_name != $product->category)
                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Image</label>
                            <div class="text-center my-4">
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{$product->title}}" class="max-w-[200px] mx-auto rounded-md shadow-lg">
                            </div>
                            <label class="block p-3 bg-blue-900/10 border border-dashed border-blue-500/30 rounded-md text-gray-300 text-center cursor-pointer transition-all duration-300 hover:bg-blue-900/20 hover:border-blue-500/50" for="image">
                                <i class="fa fa-cloud-upload"></i> Choose a new image
                            </label>
                            <input type="file" name="image" id="image" class="hidden">
                        </div>
                        @error('image')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-6">
                            <button type="submit" class="w-full px-3 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold uppercase tracking-wider rounded-md transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>