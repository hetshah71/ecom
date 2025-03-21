<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <center>
        <h3>Custome Name: {{ $data->name }}</h3>
        <h3>Custome Address: {{ $data->rec_address }}</h3>
        <h3>Custome Phone: {{ $data->phone }}</h3>
        <h2>Product title:{{$data->product->title}}</h2>
        <h2>Product Price:{{$data->product->price}}</h2>
        <img height="250" width = "250" src="{{ 'storage/' . $data->product->image }}">
    </center>

</body>

</html>