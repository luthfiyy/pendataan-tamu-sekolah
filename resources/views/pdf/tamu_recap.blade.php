<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
            line-height: 1.6;
        }

        .company-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #2c3e50;
        }

        .company-address {
            font-size: 12px;
            color: #666;
            margin: 5px 0;
        }

        .report-title {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin: 20px 0;
        }

        .report-title h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 20px;
        }

        .table-container {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 30px;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 12px 8px;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
            border: 1px solid #1a2632;
        }

        td {
            padding: 10px 8px;
            border: 1px solid #ddd;
            font-size: 11px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary-section {
            margin: 30px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .summary-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .footer-content {
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .font-bold {
            font-weight: bold;
        }

        .no-column {
            width: 60px;
        }

        .date-column {
            width: 200px;
        }

        .count-column {
            width: 150px;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        h3 {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="company-header">
        <div class="company-name">GuBook - SMKN 11 Bandung</div>
        <div class="company-address">
            Jl. Raya Cilember, RT.01/RW.04, Sukaraja<br>
            Kec. Cicendo, Kota Bandung, Jawa Barat 40153
        </div>
    </div>
    <hr>
    <div class="report-title">
        <h2>{{ $title }}</h2>
        <div style="font-size: 12px; color: #666; margin-top: 5px;">
            Periode: {{ $periode }}
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="no-column">No</th>
                    <th class="date-column">Tanggal Perjanjian</th>
                    <th class="count-column">Jumlah Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($dailyCount as $date => $count)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</td>
                        <td class="text-right">{{ $count }} kunjungan</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2" class="text-center">Total Kunjungan</td>
                    <td class="text-right">{{ $totalTamu }} kunjungan</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-title">Ringkasan:</div>
        <table style="width: 300px; margin-bottom: 0;">
            <tr>
                <td style="border: none; padding: 5px 0;">Total Hari:</td>
                <td style="border: none; padding: 5px 0;" class="text-right font-bold">{{ count($dailyCount) }} hari
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 5px 0;">Total Kunjungan:</td>
                <td style="border: none; padding: 5px 0;" class="text-right font-bold">{{ $totalTamu }} kunjungan
                </td>
            </tr>
        </table>

        @if ($statusStats)
            <div class="summary-title" style="margin-top: 20px;">Berdasarkan Status:</div>
            <table style="width: 300px; margin-bottom: 0;">
                <tr>
                    <td style="border: none; padding: 5px 0;">Menunggu Konfirmasi:</td>
                    <td style="border: none; padding: 5px 0;" class="text-right font-bold">
                        {{ $statusStats['Menunggu konfirmasi'] }} kunjungan
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 5px 0;">Diterima:</td>
                    <td style="border: none; padding: 5px 0;" class="text-right font-bold">
                        {{ $statusStats['Diterima'] }} kunjungan
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 5px 0;">Ditolak:</td>
                    <td style="border: none; padding: 5px 0;" class="text-right font-bold">
                        {{ $statusStats['Ditolak'] }} kunjungan
                    </td>
                </tr>
            </table>
        @endif
    </div>

    <div class="footer">
        <div class="footer-content">
            Dokumen ini digenerate pada {{ now()->translatedFormat('l, d F Y H:i') }}<br>
            © GuBook - Sistem Manajemen Tamu
        </div>
    </div>
</body>

</html>
