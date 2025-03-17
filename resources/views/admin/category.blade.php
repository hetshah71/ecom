<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <!-- <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 10px;
            align-items: center;
        }

        input[type="text"] {
            width: 250px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .table_deg {
            text-align: center;
            margin: auto;
            border: 2px solid yellowgreen;
            margin-top: 50px;
            width: 600px;
        }

        th {
            background-color: skyblue;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }

        td {
            color: white;
            padding: 10px;
            border: 2px solid skyblue;
        }
    </style> -->
    @vite("resources/css/app.css")
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Add Category</h1>

                    <!-- Form -->
                    <form action="{{ url('add_category') }}" method="post" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <input
                            type="text"
                            name="category"
                            placeholder="Enter category name"
                            class="w-full sm:w-auto flex-grow px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                            + Add Category
                        </button>
                    </form>

                    <!-- Table -->
                    <div class="mt-8 overflow-hidden rounded-lg border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-600 uppercase">Category Name</th>
                                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-600 uppercase">Edit</th>
                                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-600 uppercase">Delete</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($data as $data)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $data->category_name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ url('edit_category', $data->id) }}"
                                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                            ✏️ Edit
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a onclick="confirmation(event)"
                                            href="{{ url('delete_category', $data->id) }}"
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                            🗑️ Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //get the URL to redirect to
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