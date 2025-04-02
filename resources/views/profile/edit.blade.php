<!DOCTYPE html>
<html>

<head>
    @include('home.css')
</head>

<body class="bg-gray-50">
    @include('home.flash-message')
    <div class="hero_area">
        @include('home.header')
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">User Profile</h2>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">User Name</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Email</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->phone }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Address</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>