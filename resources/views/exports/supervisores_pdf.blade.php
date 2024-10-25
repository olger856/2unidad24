<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Supervisores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Supervisores</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>DNI</th>
                <th>Celular</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supervisores as $supervisor)
                <tr>
                    <td>{{ $supervisor->name }}</td>
                    <td>{{ $supervisor->email }}</td>
                    <td>{{ $supervisor->dni }}</td>
                    <td>{{ $supervisor->celular }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
