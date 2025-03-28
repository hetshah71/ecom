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
                <div class="max-w-3xl mx-auto p-8 bg-black/30 rounded-xl shadow-2xl border border-white/10">
                    <h1 class="text-white text-3xl font-bold mb-8 text-center">Add Product</h1>

                    <form id="product-form" action="{{url('/admin/upload_product')}}" method="post" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="group">
                            <label class="block mb-2 text-sm font-medium text-gray-200 group-hover:text-white transition-colors duration-200">Product Title</label>
                            <input type="text" name="title" placeholder="Enter product title" class="w-full px-4 py-3 bg-white/5 border border-white/10 focus:border-blue-500/50 rounded-lg text-white text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 hover:border-white/20">
                            <span class="error-message text-red-400 text-sm mt-1.5 hidden"></span>
                        </div>

                        <div class="group">
                            <label class="block mb-2 text-sm font-medium text-gray-200 group-hover:text-white transition-colors duration-200">Description</label>
                            <textarea name="description" placeholder="Enter product description" class="w-full px-4 py-3 bg-white/5 border border-white/10 focus:border-blue-500/50 rounded-lg text-white text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 hover:border-white/20 min-h-[120px] resize-y"></textarea>
                            <span class="error-message text-red-400 text-sm mt-1.5 hidden"></span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block mb-2 text-sm font-medium text-gray-200 group-hover:text-white transition-colors duration-200">Price</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                                    <input type="number" name="price" placeholder="0.00" class="w-full pl-8 pr-4 py-3 bg-white/5 border border-white/10 focus:border-blue-500/50 rounded-lg text-white text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 hover:border-white/20">
                                </div>
                                <span class="error-message text-red-400 text-sm mt-1.5 hidden"></span>
                            </div>

                            <div class="group">
                                <label class="block mb-2 text-sm font-medium text-gray-200 group-hover:text-white transition-colors duration-200">Quantity</label>
                                <input type="number" name="qty" placeholder="0" min="0" class="w-full px-4 py-3 bg-white/5 border border-white/10 focus:border-blue-500/50 rounded-lg text-white text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 hover:border-white/20">
                                <span class="error-message text-red-400 text-sm mt-1.5 hidden"></span>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block mb-2 text-sm font-medium text-gray-200 group-hover:text-white transition-colors duration-200">Product Category</label>
                            <select name="category" class="w-full px-4 py-3 bg-white/5 border border-white/10 focus:border-blue-500/50 rounded-lg text-white text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 hover:border-white/20 cursor-pointer appearance-none">
                                <option value="" class="bg-gray-800">Select Category</option>
                                @foreach($category as $category)
                                <option value="{{$category->category_name}}" class="bg-gray-800">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            <span class="error-message text-red-400 text-sm mt-1.5 hidden"></span>
                        </div>

                        <div class="group">
                            <label class="block mb-2 text-sm font-medium text-gray-200 group-hover:text-white transition-colors duration-200">Product Image</label>
                            <div class="relative">
                                <label class="block p-4 bg-white/5 border-2 border-dashed border-white/10 hover:border-blue-500/50 rounded-lg text-center cursor-pointer transition-all duration-200 hover:bg-blue-500/5">
                                    <i class="fa fa-cloud-upload text-2xl mb-2 text-gray-400"></i>
                                    <p class="text-sm text-gray-300">Click to upload or drag and drop<br>SVG, PNG, JPG or GIF (max. 800x400px)</p>
                                    <input type="file" name="image" id="product-image" accept="image/*" class="hidden">
                                </label>
                            </div>
                            <!-- Image preview -->
                            <div class="mt-4">
                                <img id="image-preview" src="#" alt="Image Preview" class="hidden max-h-48 rounded-lg border border-white/10 shadow-md">
                            </div>
                            <span class="error-message text-red-400 text-sm mt-1.5 hidden"></span>
                        </div>


                        <div class="pt-4">
                            <button type="submit" class="w-full px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm uppercase tracking-wider rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 active:bg-blue-800">
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("product-image").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById("image-preview");
                    preview.src = e.target.result;
                    preview.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
    <script src="{{asset('js/product-validation.js')}}"></script>
</body>

</html>