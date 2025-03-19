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
                    <h1 class="text-white text-2xl font-semibold mb-8 text-center">Add Category</h1>

                    <form action="{{ url('/admin/add_category') }}" method="post">
                        @csrf
                        <div class="mb-6">
                            <!-- <label class="block mb-2 text-sm font-medium text-gray-300">Category Name</label> -->
                            <input type="text" name="category" placeholder="Enter category name" required
                                class="w-full px-3 py-3 bg-gray-300 bg-opacity-5 border border-white border-opacity-10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-25">
                        </div>

                        <div class="mb-6">
                            <button type="submit" class="w-full px-3 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold uppercase tracking-wider rounded-md transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                Add Category
                            </button>
                        </div>
                    </form>

                    <div class="w-11/12 mx-auto mt-8 p-4 border-2 border-green-500 border-opacity-30 rounded-lg">
                        <table class="w-full">
                            <tr>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-base font-semibold uppercase tracking-wider p-4">
                                    Category Name
                                </th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-base font-semibold uppercase tracking-wider p-4">
                                    Action
                                </th>
                            </tr>
                            @foreach($data as $data)
                            <tr>
                                <td class="text-gray-300 p-3 border border-blue-900 border-opacity-10">{{ $data->category_name }}</td>
                                <td class="text-gray-300 p-3 border border-blue-900 border-opacity-10">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ url('/admin/edit_category', $data->id) }}" class="px-4 py-2 bg-green-500 bg-opacity-10 text-green-500 font-medium rounded hover:bg-green-500 hover:text-white transition-all duration-300">
                                            Edit
                                        </a>
                                        <a onclick="confirmation(event)" href="{{ url('/admin/delete_category', $data->id) }}" class="px-4 py-2 bg-red-500 bg-opacity-10 text-red-500 font-medium rounded hover:bg-red-500 hover:text-white transition-all duration-300">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Are you sure to delete This?",
                    text: "This delete will be permanent!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCncel) => {
                    if (willCncel) {
                        window.location.href = urlToRedirect;
                    }
                });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}">
    </script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>