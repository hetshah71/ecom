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
                    <h4 class="text-white text-2xl font-semibold mb-4 text-center">Deleted Products</h4>
                    <a href="{{ url('admin/view_product') }}" class="px-4 py-2 bg-blue-500 text-white font-medium rounded hover:bg-blue-600 transition-all duration-300 inline-block mb-4">
                        Back to Products
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

                    <div class="w-full mt-4 p-4 border-2 border-green-500 border-opacity-30 rounded-lg overflow-x-auto">
                        <table class="w-full border-collapse">
                            <tr>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Title</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Price</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Quantity</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Image</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Deleted At</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Action</th>
                            </tr>
                            @forelse($product as $item)
                            <tr class="hover:bg-blue-900 hover:bg-opacity-5 transition-colors duration-200">
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{ $item->title }}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{ $item->price }}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{ $item->quantity }}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">

                                    @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="max-w-[60px] rounded-lg shadow-sm transition-transform duration-200 hover:scale-105">
                                    @else
                                    No Image
                                    @endif
                                </td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{ $item->deleted_at->format('Y-m-d H:i:s') }}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">
                                    <div class="flex justify-center items-center">
                                        <a class="w-7 h-7 bg-green-600 bg-opacity-80 rounded-lg flex items-center justify-center text-white border border-white border-opacity-10 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg"
                                            href="{{ url('admin/restore_product', $item->id) }}"
                                            onclick="return confirm('Are you sure you want to restore this product?')"
                                            title="Restore Product">
                                            <i class="fa fa-undo"></i>
                                        </a>
                                        <form action="{{ url('admin/force_delete_product', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="w-7 h-7 bg-red-600 bg-opacity-80 rounded-lg flex items-center justify-center text-white border border-white border-opacity-10 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg"
                                                onclick="return confirm('Are you sure you want to permanently delete this product?')"
                                                title="Permanently Delete Product">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-300 p-3">No deleted products found</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>

                    <div class="mt-8 flex justify-center">
                        {{ $product->links() }}
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
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>