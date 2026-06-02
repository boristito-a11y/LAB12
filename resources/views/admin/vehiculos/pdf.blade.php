<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { font-family: Arial, sans-serif; font-size: 12px; }
        body { margin: 20px; color: #1a1a2e; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #1a1a2e; padding-bottom: 15px; }
        .header h1 { font-size: 22px; margin: 0; color: #1a1a2e; }
        .header p { color: #6b7280; margin: 5px 0 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead tr { background: #1a1a2e; color: white; }
        th { padding: 10px 8px; text-align: left; font-size: 11px; letter-spacing: .05em; }
        td { padding: 9px 8px; border-bottom: 1px solid #f0f2f5; }
        tr:nth-child(even) td { background: #f8fafc; }
        .badge-verde    { background: #ecfdf5; color: #065f46; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-rojo     { background: #fef2f2; color: #ef4444; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-amarillo { background: #fffbeb; color: #d97706; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #9ca3af; font-size: 10px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚗 AutoPremium — Reporte de Vehículos</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table style="width:100%;margin-bottom:15px">
        <tr>
            <td style="border:none;padding:8px 12px;background:#f8fafc;border-radius:6px;text-align:center">
                <div style="font-size:18px;font-weight:bold;color:#1a1a2e">{{ $vehiculos->count() }}</div>
                <div style="font-size:10px;color:#6b7280">Total vehículos</div>
            </td>
            <td style="border:none;padding:8px 12px;background:#f8fafc;border-radius:6px;text-align:center">
                <div style="font-size:18px;font-weight:bold;color:#059669">S/. {{ number_format($vehiculos->sum('precio'), 2) }}</div>
                <div style="font-size:10px;color:#6b7280">Valor total inventario</div>
            </td>
            <td style="border:none;padding:8px 12px;background:#fef2f2;border-radius:6px;text-align:center">
                <div style="font-size:18px;font-weight:bold;color:#ef4444">{{ $vehiculos->where('stock', 0)->count() }}</div>
                <div style="font-size:10px;color:#6b7280">Sin stock</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Año</th>
                <th>Precio</th>
                <th>Kilometraje</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehiculos as $v)
            <tr>
                <td style="color:#9ca3af">{{ $loop->iteration }}</td>
                <td style="font-weight:bold">{{ $v->modelo }}</td>
                <td>{{ $v->marca->nombre }}</td>
                <td>{{ $v->anio }}</td>
                <td style="color:#059669;font-weight:bold">S/. {{ number_format($v->precio, 2) }}</td>
                <td>{{ number_format($v->kilometraje) }} km</td>
                <td>
                    @if($v->stock == 0)
                        <span class="badge-rojo">Sin stock</span>
                    @elseif($v->stock <= 3)
                        <span class="badge-amarillo">{{ $v->stock }} uds</span>
                    @else
                        <span class="badge-verde">{{ $v->stock }} uds</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">AutoPremium — Agencia de Vehículos · Reporte generado automáticamente</div>
</body>
</html>