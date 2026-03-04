<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Consentimiento Informado</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        .info-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .content {
            margin-bottom: 50px;
            text-align: justify;
        }
        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 10px;
            padding-top: 5px;
        }
        .signature-img {
            max-width: 150px;
            max-height: 80px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>CLÍNICA MÉDICA ERP</h1>
        <p>Consentimiento Informado</p>
    </div>

    <div class="info-box">
        <strong>Paciente:</strong> {{ $record->paciente->nombre }} {{ $record->paciente->apellido }}<br>
        <strong>Documento:</strong> {{ $record->paciente->telefono }}<br>
        <strong>Fecha:</strong> {{ $record->fecha_firma ? $record->fecha_firma->format('d/m/Y H:i') : 'Pendiente' }}
    </div>

    <h2 style="text-align: center;">{{ $record->titulo }}</h2>

    <div class="content">
        {!! $record->contenido_legal !!}
    </div>

    <div class="signature-section">
        <div class="signature-box">
            @if($record->firma_digital_path)
                <img src="{{ public_path('storage/' . $record->firma_digital_path) }}" class="signature-img">
            @else
                <div style="height: 50px;"></div>
            @endif
            <div class="signature-line">
                Firma del Paciente
            </div>
        </div>
    </div>

</body>
</html>
