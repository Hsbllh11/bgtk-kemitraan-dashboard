<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Laporan BGTK Kemitraan</title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 13px;
        }

        .header p {
            margin: 3px 0;
            font-size: 9px;
        }

        .filter {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #999;
        }

        .section-title {
            margin-top: 18px;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #e9eef5;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 5px;
            vertical-align: top;
        }

        .empty {
            text-align: center;
            padding: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="header">

        <h1>
            BGTK KEMITRAAN DASHBOARD
        </h1>

        <h2>
            LAPORAN DATA KEMITRAAN
        </h2>

        <p>
            Nusa Tenggara Barat
        </p>

        <p>
            Dicetak:
            {{ now()->format('d-m-Y H:i:s') }}
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMASI FILTER --}}
    {{-- ========================================================= --}}

    <div class="filter">

        <strong>Filter Laporan</strong>

        <br><br>

        Kabupaten / Kota:
        <strong>
            {{ $kabupatenKota ?: 'Semua' }}
        </strong>

        &nbsp;&nbsp;&nbsp;&nbsp;

        Status:
        <strong>
            {{ $status ?: 'Semua' }}
        </strong>

    </div>


    {{-- ========================================================= --}}
    {{-- REKAP DATA KEANGGOTAAN --}}
    {{-- ========================================================= --}}

    <div class="section-title">
        Rekap Data Keanggotaan
    </div>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP / NIK</th>
                <th>Instansi</th>
                <th>Kabupaten / Kota</th>
                <th>Jabatan</th>
                <th>Jenis Mitra</th>
                <th>Peran</th>
                <th>Status</th>
                <th>Tanggal Bergabung</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($keanggotaans as $index => $keanggotaan)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $keanggotaan->nama }}</td>

                    <td>{{ $keanggotaan->nip_nik }}</td>

                    <td>{{ $keanggotaan->instansi }}</td>

                    <td>{{ $keanggotaan->kabupaten_kota }}</td>

                    <td>{{ $keanggotaan->jabatan }}</td>

                    <td>{{ $keanggotaan->jenis_mitra }}</td>

                    <td>{{ $keanggotaan->peran }}</td>

                    <td>{{ $keanggotaan->status }}</td>

                    <td>
                        {{ $keanggotaan->tanggal_bergabung?->format('d-m-Y') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="10" class="empty">
                        Tidak ada data keanggotaan.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- REKAP DATA MITRA --}}
    {{-- ========================================================= --}}

    <div class="section-title">
        Rekap Data Mitra
    </div>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama Mitra</th>
                <th>Jenis Mitra</th>
                <th>Instansi</th>
                <th>Kabupaten / Kota</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Email</th>
                <th>Status</th>
                <th>Tanggal Bergabung</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($mitras as $index => $mitra)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $mitra->nama_mitra }}</td>

                    <td>{{ $mitra->jenis_mitra }}</td>

                    <td>{{ $mitra->instansi }}</td>

                    <td>{{ $mitra->kabupaten_kota }}</td>

                    <td>{{ $mitra->alamat }}</td>

                    <td>{{ $mitra->kontak }}</td>

                    <td>{{ $mitra->email }}</td>

                    <td>{{ $mitra->status }}</td>

                    <td>
                        {{ $mitra->tanggal_bergabung?->format('d-m-Y') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="10" class="empty">
                        Tidak ada data mitra.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- REKAP DATA KEGIATAN --}}
    {{-- ========================================================= --}}

    <div class="section-title">
        Rekap Data Kegiatan
    </div>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Jenis Kegiatan</th>
                <th>Kabupaten / Kota</th>
                <th>Lokasi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Penanggung Jawab</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($kegiatans as $index => $kegiatan)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $kegiatan->nama_kegiatan }}</td>

                    <td>{{ $kegiatan->jenis_kegiatan }}</td>

                    <td>{{ $kegiatan->kabupaten_kota }}</td>

                    <td>{{ $kegiatan->lokasi }}</td>

                    <td>
                        {{ $kegiatan->tanggal_mulai?->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $kegiatan->tanggal_selesai?->format('d-m-Y') }}
                    </td>

                    <td>{{ $kegiatan->penanggung_jawab }}</td>

                    <td>{{ $kegiatan->status }}</td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="empty">
                        Tidak ada data kegiatan.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- REKAP DATA PROGRAM --}}
    {{-- ========================================================= --}}

    <div class="section-title">
        Rekap Data Program
    </div>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama Program</th>
                <th>Jenis Program</th>
                <th>Kabupaten / Kota</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Penanggung Jawab</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($programs as $index => $program)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $program->nama_program }}</td>

                    <td>{{ $program->jenis_program }}</td>

                    <td>{{ $program->kabupaten_kota }}</td>

                    <td>
                        {{ $program->tanggal_mulai?->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $program->tanggal_selesai?->format('d-m-Y') }}
                    </td>

                    <td>{{ $program->penanggung_jawab }}</td>

                    <td>{{ $program->status }}</td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="empty">
                        Tidak ada data program.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</body>

</html>