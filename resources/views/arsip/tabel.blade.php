<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $nama }}</title>
    <style>
        body { font-family: system-ui, sans-serif; font-size: 13px; margin: 0; background:#fff; color:#1f1f1f; }
        .tabs { position: sticky; top: 0; display:flex; gap:4px; padding:8px; background:#f0f4f9; border-bottom:1px solid #dadce0; flex-wrap:wrap; }
        .tabs button { border:0; padding:6px 14px; border-radius:6px; background:transparent; cursor:pointer; }
        .tabs button.on { background:#c2e7ff; font-weight:600; }
        .sheet { display:none; overflow:auto; }
        .sheet.on { display:block; }
        table { border-collapse: collapse; }
        td { border:1px solid #dadce0; padding:4px 8px; white-space:nowrap; }
        tr:first-child td { background:#f8f9fa; font-weight:600; position:sticky; top:0; }
        .note { padding:8px 12px; background:#fff8e1; color:#8a6d00; }
    </style>
</head>
<body>
    <div class="tabs">
        @foreach ($sheets as $i => $s)
            <button type="button" class="{{ $i === 0 ? 'on' : '' }}" onclick="show({{ $i }})">{{ $s['title'] }}</button>
        @endforeach
    </div>

    @foreach ($sheets as $i => $s)
        <div class="sheet {{ $i === 0 ? 'on' : '' }}" id="sheet-{{ $i }}">
            @if ($s['truncated'])
                <div class="note">Menampilkan 500 dari {{ number_format($s['total']) }} baris. Download file untuk data lengkap.</div>
            @endif
            <table>
                @foreach ($s['rows'] as $row)
                    <tr>@foreach ($row as $cell)<td>{{ $cell }}</td>@endforeach</tr>
                @endforeach
            </table>
        </div>
    @endforeach

    <script>
        function show(i) {
            document.querySelectorAll('.sheet').forEach((el, k) => el.classList.toggle('on', k === i));
            document.querySelectorAll('.tabs button').forEach((el, k) => el.classList.toggle('on', k === i));
        }
    </script>
</body>
</html>