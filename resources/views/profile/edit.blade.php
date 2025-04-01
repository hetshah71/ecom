<!DOCTYPE html>
<html>

<head>

    @include('home.css')
</head>

<body>
    @include('home.flash-message')
    <div class="hero_area">

        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->



    </div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-black">User Management</h2>
    </div>
    <div class="div_center">
        <table>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>address</th>
            </tr>
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
            </tr>

            
        </table>
    </div>
    </div>


</body>

</html>