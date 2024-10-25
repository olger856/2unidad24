<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oferta Laboral - {{ $offer->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            color: #007BFF;
        }
        .details {
            margin-top: 20px;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Oferta Laboral: {{ $offer->title }}</h1>
    <div class="details">
        <div class="detail-item">
            <span class="label">Empresa:</span> {{ $offer->user->name ?? 'No asignada' }}
        </div>
        <div class="detail-item">
            <span class="label">Descripción:</span> {{ $offer->description }}
        </div>
        <div class="detail-item">
            <span class="label">Ubicación:</span> {{ $offer->location }}
        </div>
        <div class="detail-item">
            <span class="label">Salario:</span> {{ $offer->salary ? '$' . number_format($offer->salary, 2) : 'No especificado' }}
        </div>
        <div class="detail-item">
            <span class="label">Fecha de Inicio:</span> {{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('d/m/Y H:i') : 'No definida' }}
        </div>
        <div class="detail-item">
            <span class="label">Fecha de Fin:</span> {{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y H:i') : 'No definida' }}
        </div>
        <div class="detail-item">
            <span class="label">Número de Postulantes:</span> {{ $numberOfApplicants }}
        </div>
        <!-- más detalles -->
    </div>
</body>
</html>
