<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mis Postulaciones</title>
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
    <h1>Mis Postulaciones</h1>
    <table>
        <thead>
            <tr>
                <th>Oferta laboral</th>
                <th>Empresa</th>
                <th>Ubicación</th>
                <th>Salario</th>
                <th>Postulado el</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobOffers as $jobOffer)
                <tr>
                    <td>{{ $jobOffer->title }}</td>
                    <td>{{ $jobOffer->user->name }}</td>
                    <td>{{ $jobOffer->location }}</td>
                    <td>S/{{ number_format($jobOffer->salary, 2) }}</td>
                    <td>{{ $jobOffer->postulantes->firstWhere('id', Auth::id())->pivot->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
