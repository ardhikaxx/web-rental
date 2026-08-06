<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 2px; }
        .title { text-align: center; margin-bottom: 15px; }
        p { margin: 0 0 4px; }
        .meta { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 5px 7px; text-align: left; }
        th { background: #eef; }
        .right { text-align: right; }
        .foot { margin-top: 12px; font-size: 10px; color: #666; text-align: center; }
    </style>
</head>
<body>
    <div class="title">
        <h2>{{ $title }}</h2>
        <p>RC Trans Bondowoso - Rental Mobil & Wisata</p>
        @if($from && $to)<p>Periode: {{ $from }} - {{ $to }} | Dicetak: {{ now()->format('d-m-Y H:i') }}</p>@else<p>Dicetak: {{ now()->format('d-m-Y H:i') }}</p>@endif
    </div>
    <table>
        <thead>
            <tr>
                @foreach ($head as $h)<th>{{ $h }}</th>@endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                @foreach ($row as $cell)<td>{{ is_array($cell) ? json_encode($cell) : $cell }}</td>@endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="foot">Laporan ini dibuat otomatis oleh sistem RC Trans.</div>
</body>
</html>