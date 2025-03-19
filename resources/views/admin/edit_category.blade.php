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
                    <h1 class="text-white text-2xl font-semibold mb-8 text-center">Update Category</h1>

                    <form action="{{url('/admin/update_category',$data->id)}}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-300">Category Name</label>
                            <input type="text" name="category" value="{{$data->category_name}}" placeholder="Enter category name" required
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                        </div>

                        <div class="mb-6">
                            <button type="submit" class="w-full px-3 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold uppercase tracking-wider rounded-md transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                Update Category
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