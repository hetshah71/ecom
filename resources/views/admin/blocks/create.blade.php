<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    @vite("resources/css/app.css")
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="flex-grow p-4 space-y-6">
        <!-- Form -->
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <form action="{{ route('admin.blocks.store') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Title Field -->
                <div class="flex flex-col space-y-1">
                    <label for="title" class="text-md font-semibold text-gray-700">Title</label>
                    <input type="text" name="title" id="title"
                        class="w-full block-title border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('title')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
                <!-- Slug Field -->
                <div class="flex flex-col space-y-1">
                    <label for="slug" class="text-md font-semibold text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug"
                        class="w-full block-slug border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <!-- Summernote Editor -->
                <div class="flex flex-col space-y-1">
                    <label for="summernote" class="text-md font-semibold text-gray-700">Content</label>
                    <textarea name="content" id="summernote"></textarea>
                </div>
                @error('content')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
                <!-- Status Field -->
                <div class="flex flex-col space-y-1">
                    <label for="status" class="text-md font-semibold text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                @error('status')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                        Save Block
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('.block-title').on("input", function(e) {
            e.preventDefault();
            console.log("hii");
            let slug = $(this).val()
                .toLowerCase()
                .replace(/ /g, "-") // Replace spaces with hyphens
                .replace(/[^\w-]+/g, ""); // Remove non-word characters
            console.log(slug);
            if (slug) $('.block-slug').val(slug);
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

    <!-- Load Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <!-- Summernote Script -->
    <script>
        // Ensure jQuery is fully loaded before initializing Summernote
        $(document).ready(function() {
            // Small delay to ensure all dependencies are loaded
            setTimeout(function() {
                $('#summernote').summernote({
                    placeholder: 'Enter your content here...',
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview']]
                    ]
                });
            }, 100);
        });
    </script>
</body>

</html>