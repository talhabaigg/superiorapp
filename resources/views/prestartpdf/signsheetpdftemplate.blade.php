<!-- resources/views/pdf/prestart.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Sign Sheet Template</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            /* Default text color */
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
    </style>
</head>
<body>
    <h1>Daily Pre-start</h1>
    <table>
        <tr>
            <th class="headertd">Project Name</th>
            <td class="headertd">{{$prestart->project->project_name}}</td>
            <th class="headertd">Date</th>
            <td class="headertd">{{$formattedDate}}</td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Signed by</th>
                <th>Time</th>
                <th>Location</th>
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
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        
            @for ($i = $userCount; $i < $totalRows; $i++)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
