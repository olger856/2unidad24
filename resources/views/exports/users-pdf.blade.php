<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Postulantes</title>
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
    <h1>Lista de Postulantes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado de Aprobación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postulantes as $postulante)
            <tr>
                <td>{{ $postulante->id }}</td>
                <td>{{ $postulante->name }}</td>
                <td>{{ $postulante->dni }}</td>
                <td>{{ $postulante->email }}</td>
                <td>{{ $postulante->getRoleName() }}</td>
                <td>{{ $postulante->is_approved ? 'Aprobado' : 'No Aprobado' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
