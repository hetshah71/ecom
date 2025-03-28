<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="text-center text-2xl font-semibold mt-5 mb-8 text-white">All Products</h2>
                <div class="max-w-7xl mx-auto px-4">
                    <div class="mb-6 relative">
                        <input type="text" id="searchInput" placeholder="Search products by title, description or category..." class="w-full px-4 py-3 pl-10 bg-white/5 border border-white/10 rounded-md text-white text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/25 placeholder-gray-400">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <div class="bg-opacity-20 bg-black rounded-lg shadow-lg border border-opacity-10 border-white p-4 overflow-x-auto">
                        <table class="w-full border-collapse">
                            <tr>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Product Title</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Description</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Category</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Price(₹)</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Quantity</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Image</th>
                                <th class="bg-blue-900 bg-opacity-10 text-white text-sm font-semibold uppercase tracking-wider p-1.5 border-b border-blue-900 border-opacity-20">Action</th>
                            </tr>
                            @foreach($product as $products)
                            <tr class="hover:bg-blue-900 hover:bg-opacity-5 transition-colors duration-200">
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{$products->title}}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{!!Str::limit($products->description,50)!!}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{$products->category}}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{$products->price}}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">{{$products->quantity}}</td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">
                                    <img src="{{ asset('storage/'.$products->image) }}" alt="{{$products->title}}" class="max-w-[60px] rounded-lg shadow-sm transition-transform duration-200 hover:scale-105">
                                </td>
                                <td class="border-b border-white/5 text-center p-1.5 text-gray-300 text-sm align-middle">
                                    <div class="flex justify-center items-center gap-0.5">
                                        <a class="w-7 h-7 bg-blue-600 bg-opacity-80 rounded-lg flex items-center justify-center text-white border border-white border-opacity-10 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg" href="{{url('/admin/edit_product',$products->id)}}" title="Edit Product">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="w-7 h-7 bg-red-600 bg-opacity-80 rounded-lg flex items-center justify-center text-white border border-white border-opacity-10 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg" onclick="confirmation(event)" href="{{url('/admin/delete_product',$products->id)}}" title="Delete Product">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="mt-8 flex justify-center">
                        {{ $product->onEachSide(3)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            let searchTimeout;
            const debounceDelay = 300; // 300ms delay

            function performSearch() {
                const value = $('#searchInput').val().toLowerCase();
                $('table tr').not(':first').each(function() {
                    const $row = $(this);
                    const title = $row.find('td:nth-child(1)').text().toLowerCase();
                    const description = $row.find('td:nth-child(2)').text().toLowerCase();
                    const category = $row.find('td:nth-child(3)').text().toLowerCase();
                    const matches = title.indexOf(value) > -1 ||
                        description.indexOf(value) > -1 ||
                        category.indexOf(value) > -1;
                    $row.toggle(matches);
                });
            }

            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, debounceDelay);
            });
        });
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            swal({
                    title: "Are you sure to delete this?",
                    text: "This delete will be permanent!",
                    icon: "warning",
                    buttons: ["Cancel", "Yes, delete it!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = urlToRedirect;
                    }
                });
        }
    </script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>