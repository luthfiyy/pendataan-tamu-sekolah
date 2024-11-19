<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
            line-height: 1.6;
        }

        /* Header Styles */
        .header {
            margin-bottom: 40px;
        }

        .company-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-logo {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
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

        /* Table Styles */
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

        /* Summary Section */
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

        /* Footer Styles */
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

        .page-number {
            text-align: right;
            font-size: 10px;
            color: #999;
            font-style: italic;
        }

        /* Additional Utility Classes */
        .font-bold {
            font-weight: bold;
        }

        .no-column {
            width: 40px;
        }

        .date-column {
            width: 150px;
        }

        .phone-column {
            width: 100px;
        }
    </style>
</head>
<body>
    <!-- Company Header -->
    <div class="company-header">
        <div class="company-name">GuBook - SMKN 11 Bandung</div>
        <div class="company-address">
            Jl. Raya Cilember, RT.01/RW.04, Sukaraja<br>
            Kec. Cicendo, Kota Bandung, Jawa Barat 40153
        </div>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h2>{{ $title }}</h2>
        <div style="font-size: 12px; color: #666; margin-top: 5px;">
            Periode: {{ $periode }}
        </div>
    </div>

    <!-- Table Content -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="no-column">No</th>
                    <th>Nama Kurir</th>
                    <th>Ekspedisi</th>
                    <th class="phone-column">No Telepon</th>
                    <th>Pegawai yang Dituju</th>
                    <th class="date-column">Tanggal & Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="font-bold">{{ ucwords(strtolower($item->ekspedisi->nama_kurir)) }}</td>
                        <td>{{ $item->ekspedisi->ekspedisi }}</td>
                        <td class="text-center">{{ $item->ekspedisi->no_telp }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td class="text-center">{{ Carbon\Carbon::parse($item->tanggal_waktu)->translatedFormat('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            Dokumen ini digenerate pada {{ now()->translatedFormat('l, d F Y H:i') }}<br>
            © GuBook - Sistem Manajemen Tamu
        </div>
    </div>
</body>
</html>
