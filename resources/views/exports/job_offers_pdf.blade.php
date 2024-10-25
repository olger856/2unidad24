<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas Laborales</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Ofertas Laborales</h1>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Salario</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobOffers as $offer)
                <tr>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->description }}</td>
                    <td>{{ $offer->location }}</td>
                    <td>S/{{ number_format($offer->salary, 2) }}</td>
                    <td>{{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('d/m/Y H:i') : 'No definida' }}</td>
                    <td>{{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y H:i') : 'No definida' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
