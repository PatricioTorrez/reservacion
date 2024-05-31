<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tickets PDF</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
        }
        .ticket {
            margin-bottom: 20px;
            border: 1px solid #e3e6f0;
            padding: 15px;
        }
        .header {
            background-color: #4e73df;
            color: #fff;
            padding: 10px;
        }
        .content {
            padding: 15px;
            background-color: #f8f9fc;
        }
    </style>
</head>
<body>
@forelse($tickets as $ticket)
    <div class="ticket">
        <div class="header">
            <h2>Ticket de: {{ optional($ticket->getreservaciones)->nombre }} {{ optional($ticket->getreservaciones)->ap }} {{ optional($ticket->getreservaciones)->am }}</h2>
        </div>
        <div class="content">
            <p><b>Fecha del Pago:</b> {{ $ticket->fecha_pago }}</p>
            <p><b>Fecha de Reserva:</b> {{ optional($ticket->getreservaciones)->fecha_inicio }} - {{ $ticket->getreservaciones->fecha_fin }}</p>
            <p><b>Total Pago:</b> ${{ number_format($ticket->precio_total, 2) }}</p>
            <p><b>Hotel:</b> {{ optional($ticket->gethoteles)->nombre }}</p>
            <p><b>Número de Cuenta:</b> {{ optional($ticket->gettarjetas)->numero }}</p>
        </div>
    </div>
@empty
    <p>No hay tickets disponibles.</p>
@endforelse
</body>
</html>
