<!-- resources/views/pdf/prestart.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Prestart PDF</title>
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
        .logo {
            position: relative;
            top: 10px;
            left: 10px;
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
    </style>
</head>
<body>
    
    <img src="{{ public_path('logo1.jpg') }}" alt="Logo" class="logo">
    <div class="line"></div>
    <h1>Daily Pre-start</h1>
    
    <table>
        <tr>
            <th class="headertd">Project Name</th>
            <td class="headertd">{{$prestart->project->project_name}}</td>
            <th class="headertd">Date</th>
            <td class="headertd">{{$formattedDate}}</td>
        </tr>
        <tr>
            <th class="headertd">No of workers</th>
            <td class="headertd"> 
                @if($prestart->prestartSigned->isNotEmpty())
                {{ $prestart->prestartSigned->where('status', 'onsite')->count() }}
                @else
                0
                 @endif
            </td>
            <th class="headertd">No. of absentees</th>
            <td class="headertd"> {{ $prestart->prestartSigned->whereIn('status', ['sick', 'other'])->count() }}</td>
        </tr>
        <tr>
            <th class="headertd">Foreman</th>
            <td class="headertd" colspan="3">
                @if ($prestart->foreman)
        {{ $prestart->foreman->name }}
    @else
        No foreman selected
    @endif
            </td>
        </tr>
        <tr>
            <th class="headertd">Weather</th>
            <td class="headertd" colspan="3">{{$prestart->weather}}</td>
        </tr>
        <tr>
            <th class="headertd">Weather impact</th>
            <td class="headertd" colspan="3">{{$prestart->weather_impact}}</td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>General site works / activities</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestart->activities  as $activity)
                <tr>
                    <td>{{ $activity['name'] }}</td>
                
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>Safety concerns / incidents</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestart->incidents  as $incident)
                <tr>
                    <td>{{ $incident['name'] }}</td>
                
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
