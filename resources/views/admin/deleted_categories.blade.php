<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    @vite("resources/css/app.css")
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="max-w-7xl mx-auto p-8 bg-black bg-opacity-20 rounded-lg shadow-lg">
                    <h4 class="text-white text-2xl font-semibold mb-4 text-center">Deleted Categories</h4>
                    <a href="{{ url('admin/view_category') }}" class="px-4 py-2 bg-blue-500 text-white font-medium rounded hover:bg-blue-600 transition-all duration-300 inline-block mb-4">
                        Back to Categories
                    </a>
                        
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session()->get('success') }}
                    </div>
                    @endif

                    @if(session()->has('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session()->get('error') }}
                    </div>
                    @endif
                        
                    <div class="w-full mt-4 p-4 border-2 border-green-500 border-opacity-30 rounded-lg">
                        <table class="w-full">
                            <tr>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-base font-semibold uppercase tracking-wider p-4">
                                    Category Name
                                </th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-base font-semibold uppercase tracking-wider p-4">
                                    Deleted At
                                </th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-base font-semibold uppercase tracking-wider p-4">
                                    Action
                                </th>
                            </tr>
                            @forelse($data as $category)
                            <tr>
                                <td class="text-gray-300 p-3 border border-blue-900 border-opacity-10">{{ $category->category_name }}</td>
                                <td class="text-gray-300 p-3 border border-blue-900 border-opacity-10">{{ $category->deleted_at->format('Y-m-d H:i:s') }}</td>
                                <td class="text-gray-300 p-3 border border-blue-900 border-opacity-10">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ url('admin/restore_category', $category->id) }}" 
                                           class="px-4 py-2 bg-green-500 bg-opacity-10 text-green-500 font-medium rounded hover:bg-green-500 hover:text-white transition-all duration-300"
                                           onclick="return confirm('Are you sure you want to restore this category?')">
                                            Restore
                                        </a>
                                        <form method="post" action="{{ url('admin/force_delete_category', $category->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="px-4 py-2 bg-red-500 bg-opacity-10 text-red-500 font-medium rounded hover:bg-red-500 hover:text-white transition-all duration-300" onclick="return confirm('Are you sure you want to permanently delete this category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-300 p-3">No deleted categories found</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript files-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>