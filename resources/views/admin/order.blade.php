<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content bg-gray-900 min-h-screen">
        <div class="page-header">
            <div class="container-fluid px-6 py-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-4xl font-extrabold text-white tracking-tight">Order Management</h2>
                    <div class="relative w-72">
                        <input type="text" id="search-orders" placeholder="Search orders..." class="w-full px-5 py-3 bg-gray-800 border-2 border-gray-700 rounded-xl text-gray-300 placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-700/50">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-700 bg-gray-800/70">
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Customer Name</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Address</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Phone Number</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Product Title</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Price</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Image</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Actions</th>
                                    <th class="p-2 text-xs font-bold text-gray-300 uppercase tracking-wider">Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="p-2 text-sm font-medium text-gray-200">{{$order->name}}</td>
                                    <td class="p-2 text-sm font-medium text-gray-200">{{$order->rec_address}}</td>
                                    <td class="p-2 text-sm font-medium text-gray-200">{{$order->phone}}</td>
                                    <td class="p-2 text-sm font-medium text-gray-200">{{$order->product->title}}</td>
                                    <td class="p-2 text-sm font-medium text-gray-200">${{number_format($order->product->price, 2)}}</td>
                                    <td class="p-2">
                                        <div class="relative group">
                                            <img class="w-24 h-24 object-cover rounded-lg shadow-lg cursor-pointer transform hover:scale-105 transition-all duration-200" src="{{asset('storage/'.$order->product->image)}}" alt="{{$order->product->title}}" onclick="openImageModal(this.src)">
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        @if($order->status == 'in process')
                                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-amber-500/20 text-amber-200 border border-amber-500/20">{{$order->status}}</span>
                                        @elseif($order->status == 'on the way')
                                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-blue-500/20 text-blue-200 border border-blue-500/20">{{$order->status}}</span>
                                        @else
                                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-emerald-500/20 text-emerald-200 border border-emerald-500/20">{{$order->status}}</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="flex space-x-2">
                                            <a href="{{url('/admin/on_the_way',$order->id)}}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                On the way
                                            </a>
                                            <a href="{{url('/admin/delivered',$order->id)}}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Delivered
                                            </a>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <a href="{{url('/admin/print_pdf',$order->id)}}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 w-fit">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Print PDF
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
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
    <script>
        let searchTimeout;
        const searchInput = document.getElementById('search-orders');
        const tableBody = document.querySelector('tbody');
        const rows = Array.from(tableBody.querySelectorAll('tr'));

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = e.target.value.toLowerCase();

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            }, 300);
        });
    </script>
    <!-- Add Modal for Image Preview -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
        <div class="relative max-w-4xl w-full">
            <img id="modalImage" src="" alt="Product Preview" class="w-full h-auto rounded-lg shadow-2xl">
            <button onclick="closeImageModal()" class="absolute -top-4 -right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 focus:outline-none">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</body>

</html>