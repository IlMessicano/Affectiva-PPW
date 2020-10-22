<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data->nomeTask }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<table class="table table-bordered">
    <thead>
    <tr class="table-danger">
        <td>Name</td>
    </tr>
    </thead>
    <tbody>


    <tr>
        <td>{{ $data->nomeTask }}</td>
    </tr>

    </tbody>
</table>
</body>
</html>
