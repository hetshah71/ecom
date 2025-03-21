<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    @vite("resources/css/app.css")
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="max-w-3xl mx-auto p-8 bg-black bg-opacity-20 rounded-lg shadow-lg">
                    <h1 class="text-white text-2xl font-semibold mb-8 text-center">Add Product</h1>

                    <form action="{{url('/admin/upload_product')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Title</label>
                            <input type="text" name="title" required placeholder="Enter product title"
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Description</label>
                            <textarea name="description" required placeholder="Enter product description"
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25 min-h-[100px] resize-y"></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Price</label>
                            <input type="number" name="price" required placeholder="Enter product price"
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Quantity</label>
                            <input type="number" name="qty" required placeholder="Enter product quantity"
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Category</label>
                            <select name="category" required
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25 cursor-pointer">
                                <option value="">Select Category</option>
                                @foreach($category as $category)
                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Product Image</label>
                            <input type="file" name="image" accept="image/*" required
                                class="w-full px-3 py-2 bg-white bg-opacity-5 border border-white border-opacity-10 rounded-md text-black text-sm">
                        </div>

                        <div class="mb-6">
                            <button type="submit"
                                class="w-full px-3 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold uppercase tracking-wider rounded-md transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>