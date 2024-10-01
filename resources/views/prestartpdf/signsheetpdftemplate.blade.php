<!DOCTYPE html>
<html>
<head>
    <title>Sign Sheet Template</title>
    <style>
        .pagenum:before {
        content: counter(page);
    }
        body {
            margin-top: 50px; /* Leave space for the header */
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #000000;
            padding: 8px;
        }
        th {
            background-color: #4495d1;
            color: #fff;
        }
        .headertd {
            width: 25%;
            text-align: left;
        }
        .logo {
            width: auto;
            height: 75px;
        }
        .line {
            margin-top: 10px;
            border-bottom: 1px solid #000000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 1px;
            opacity: 0.6;
        }
        header {
            position: fixed;
            top: -150px; /* Adjust based on the margin space */
            left: 0;
            right: 0;
            height: 150px;
        }
        @page {
            margin-top: 160px; /* Ensures enough space for the header */
        }
        .content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <header>
        
        <img src="{{ public_path('logo1.jpg') }}" alt="Logo" class="logo">
        <div class="line"></div>
        <h1>Daily Pre-start - Page: <span class="pagenum"></span></h1>
        <table>
            <tr>
                <th class="headertd">Project Name</th>
                <td class="headertd">{{$prestart->project->project_name}}</td>
                <th class="headertd">Date</th>
                <td class="headertd">{{$formattedDate}}</td>
            </tr>
        </table>
    </header>

    <!-- Content that starts below the header -->
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Signed by</th>
                    <th>Time</th>
                    @if ($type === 'signin')
                    <th>Location</th>
                        @endif
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 1;
                    $userCount = count($prestart->project->users);
                    $totalRows = $userCount + 5; // Total rows including the additional 5
                @endphp
            
                @foreach ($prestart->project->users as $user)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $user['name'] }}</td>
                        @if ($type === 'signin')
                            <td></td>
                        @endif
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            
                @for ($i = $userCount; $i < $totalRows; $i++)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td></td>
                        @if ($type === 'signin')
                            <td></td>
                        @endif
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    
</body>
</html>
