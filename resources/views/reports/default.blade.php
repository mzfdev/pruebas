<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .report-info {
            margin-bottom: 20px;
        }
        .report-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-info th, .report-info td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .report-info th {
            background-color: #f2f2f2;
        }
        .inscriptions {
            margin-top: 20px;
        }
        .inscriptions table {
            width: 100%;
            border-collapse: collapse;
        }
        .inscriptions th, .inscriptions td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .inscriptions th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ $generatedAt }}</p>
    </div>

    <div class="report-info">
        <h2>Report Information</h2>
        <table>
            <tr>
                <th>ID</th>
                <td>{{ $report->id }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $report->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $report->reportStatus->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Format</th>
                <td>{{ $format->name }}</td>
            </tr>
        </table>
    </div>

    @if($report->reportInscriptions->count() > 0)
    <div class="inscriptions">
        <h2>Report Inscriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Subject</th>
                    <th>Qualification</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->reportInscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->id }}</td>
                    <td>{{ $inscription->student->name ?? 'N/A' }}</td>
                    <td>{{ $inscription->subject->name ?? 'N/A' }}</td>
                    <td>{{ $inscription->qualification ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>This is an automatically generated report. Do not modify.</p>
    </div>
</body>
</html>