<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    @vite("resources/css/app.css")
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="flex-grow p-4 space-y-6">
        <!-- Form -->
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <form action="{{ route('admin.blocks.update',$block->slug) }}" method="Post" class="space-y-6">
                @csrf
                @method('PATCH')
                <!-- Title Field -->
                <div class="flex flex-col space-y-1">
                    <label for="title" class="text-md font-semibold text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{$block->title}}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('title')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
                <!-- Slug Field -->
                <div class="flex flex-col space-y-1">
                    <label for="slug" class="text-md font-semibold text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{$block->slug}}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <!-- Summernote Editor -->
                <div class="flex flex-col space-y-1">
                    <label for="summernote" class="text-md font-semibold text-gray-700">Content</label>
                    <textarea name="content" id="summernote">{{$block->content}}</textarea>
                </div>
                @error('content')
                <p class="text-red-500">{{ $message }}</p>
                @enderror
                <!-- Status Field -->
                <div class="flex flex-col space-y-1">
                    <label for="status" class="text-md font-semibold text-gray-700">Status</label>
                    <select name="status" id="status" value="{{$block->status}}"
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
                        Update Block
                    </button>
                </div>
            </form>
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