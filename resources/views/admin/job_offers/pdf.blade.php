<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas Laborales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden; /* Asegura que el borde redondeado funcione */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                color: #000;
            }
            table {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <h1>Ofertas Laborales</h1>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Empresa</th>
                <th>Ubicación</th>
                <th>Salario</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($job_offers as $jobOffer)
                <tr>
                    <td>{{ $jobOffer->title }}</td>
                    <td>{{ $jobOffer->description }}</td>
                    <td>{{ $jobOffer->user->name }}</td>
                    <td>{{ $jobOffer->location }}</td>
                    <td>{{ $jobOffer->salary }}</td>
                    <td>{{ \Carbon\Carbon::parse($jobOffer->start_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jobOffer->end_date)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
