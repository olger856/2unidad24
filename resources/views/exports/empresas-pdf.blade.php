<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empresas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Lista de Empresas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>RUC</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresas as $empresa)
            <tr>
                <td>{{ $empresa->id }}</td>
                <td>{{ $empresa->name }}</td>
                <td>{{ $empresa->ruc }}</td>
                <td>{{ $empresa->email }}</td>
                <td>{{ $empresa->celular }}</td>
                <td>{{ $empresa->getRoleName() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
