<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Postulaciones - {{ $jobOffer->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
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
    <h1>Postulaciones para: {{ $jobOffer->title }}</h1>
    <p><strong>Ubicación:</strong> {{ $jobOffer->location }}</p>
    <p><strong>Salario:</strong> S/{{ number_format($jobOffer->salary, 2) }}</p>
    <p><strong>Descripción:</strong> {{ $jobOffer->description }}</p>

    <h2>Lista de Postulantes</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Postulado el</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($postulantes as $postulante)
                <tr>
                    <td>{{ $postulante->name }}</td>
                    <td>{{ $postulante->email }}</td>
                    <td>
                        @if (isset($postulante->pivot))
                            @switch($postulante->pivot->status)
                                @case(App\Models\JobApplication::STATUS_PENDING)
                                    Pendiente
                                    @break
                                @case(App\Models\JobApplication::STATUS_APPROVED)
                                    Aprobado
                                    @break
                                @case(App\Models\JobApplication::STATUS_REJECTED)
                                    Rechazado
                                    @break
                                @default
                                    N/A
                            @endswitch
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if (isset($postulante->pivot) && isset($postulante->pivot->created_at))
                            {{ $postulante->pivot->created_at->format('d/m/Y H:i') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
