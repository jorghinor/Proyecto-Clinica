<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura #{{ $record->numero_factura }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }
        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .company-info h1 {
            margin: 0;
            color: #2c3e50;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            margin: 0;
            color: #e74c3c;
        }
        .client-info {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .totals-table {
            width: 40%;
            float: right;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px;
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #333;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="company-info">
                <h1>CLÍNICA MÉDICA ERP</h1>
                <p>Av. Salud 123, Ciudad Médica</p>
                <p>Tel: (555) 123-4567</p>
                <p>Email: facturacion@clinica.test</p>
            </td>
            <td class="invoice-details">
                <h2>FACTURA</h2>
                <p><strong>Nº:</strong> {{ $record->numero_factura }}</p>
                <p><strong>Fecha:</strong> {{ $record->fecha_emision->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($record->estado) }}</p>
            </td>
        </tr>
    </table>

    <div class="client-info">
        <strong>Cliente / Paciente:</strong><br>
        {{ $record->paciente->nombre }} {{ $record->paciente->apellido }}<br>
        {{ $record->paciente->direccion ?? 'Dirección no registrada' }}<br>
        {{ $record->paciente->telefono }}<br>
        {{ $record->paciente->email }}
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th style="text-align: center;">Cant.</th>
                <th style="text-align: right;">Precio Unit.</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->items as $item)
            <tr>
                <td>{{ $item->descripcion }}</td>
                <td style="text-align: center;">{{ $item->cantidad }}</td>
                <td style="text-align: right;">${{ number_format($item->precio_unitario, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td>${{ number_format($record->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Impuestos:</strong></td>
            <td>${{ number_format($record->impuestos, 2) }}</td>
        </tr>
        <tr class="total-row">
            <td><strong>TOTAL:</strong></td>
            <td>${{ number_format($record->total, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Gracias por su preferencia. Este documento es un comprobante válido.</p>
    </div>

</body>
</html>
