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
            text-align: center;
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
    <hr>
    <!-- Report Title -->
    <div class="report-title">
        <h2>{{ $title }}</h2>
        <div style="font-size: 12px; color: #666; margin-top: 5px;">
            Periode: {{ $periode }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Informasi Tamu</th>
                <th>No. Telp</th>
                <th>Pegawai yang dituju</th>
                <th>Waktu Perjanjian</th>
                <th>Waktu Kedatangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($guests as $guest)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>
                        <h4>{{ ucwords(strtolower($guest->tamu->nama)) }}</h4>
                        <span>{{ $guest->tamu->email }}</span>
                    </td>
                    <td>{{ $guest->tamu->no_telp }}</td>
                    <td>{{ $guest->user->name }}</td>
                    <td>{{ $guest->waktu_perjanjian }}</td>
                    <td>{{ $guest->waktu_kedatangan }}</td>
                    <td>{{ $guest->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-content">
            Dokumen ini digenerate pada {{ now()->translatedFormat('l, d F Y H:i') }}<br>
            © GuBook - Sistem Manajemen Tamu
        </div>
    </div>
</body>

</html>
