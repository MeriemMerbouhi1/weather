<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <title>Weather App</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* background-image: url('images/background.jpg'); */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-size: cover;
            transition: background-image 10s ease-in-out;
        }

        h1 {
            color: #4cb7ff;
            margin-bottom: 20px;
            text-align: center;
            font-size: 55px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        label {
            font-size: 35px;
            margin-bottom: 10px;
            color: #f7f7f7;
            font-family: monospace;
        }

        input {
            padding: 10px;
            font-size: 20px;
            margin-bottom: 20px;
            width: 90%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }


        button {
            padding: 10px 20px;
            font-size: 25px;
            background-color: #4cb7ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        h2 {
            color: #4cb7ff;
            margin-top: 20px;
        }

        p {
            font-size: 40px;
            margin-bottom: 10px;

        }

        .error {
            color: #e74c3c;
            font-size: 18px;
            margin-top: 20px;
        }
        .weather{
            background: #337498d1;
            border-radius: 24px;
            padding: 44px;
            padding-bottom: 113px;
        }
        .weather-icon {
            font-size: 60px;
            margin-bottom: 10px;
        }
        .temp{
            color: #f7f7f7;
            font-family: monospace;
        }
        .weather-header {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .weather-header h2 {
            margin-left: 30px; /* Adjust the spacing as needed */
            font-size: 46px;
        }
        .temperature-icon {
            font-size: 48px;
            margin-right: 5px; /* Adjust the spacing as needed */
        }
        .clear-sky-day{
            background-image: url('images/sunny.jpg');
            background-size: cover;
        }

        .few-clouds-day {
            background-image: url('images/cloudy.jpg');
            background-size: cover;
        }

        .thunderstorm-day
        .thunderstorm-night,{
            background-image: url('images/thunderstorm.jpg');
            background-size: cover;
        }
        .snow-day,
        .snow-night{
            background-image: url('images/snow.jpg');
            background-size: cover;
        }
        /* Add more styles for other weather conditions as needed */

        /* Default background for cases where the weather condition is not specified */
        body.default-background {

            background-image: url('images/background.jpg');
            background-size: cover;
        }
        .few-clouds-night,
        .clear-sky-night{
            background-image: url('images/night.jpg');
            background-size: cover;
        }
        .shower-rain-day,
        .shower-rain-night,
        .rain-day,
        .rain-night{
            background-image: url('images/rain.jpg');
            background-size: cover;
        }
        .scattered-clouds-day,
               .scattered-clouds-night,
                .broken-clouds-day,
                .broken-clouds-night{
                    background-image: url('images/cloudy.jpg');
                    background-size: cover;
                }
    .mist-day,
    .mist-night{
        background-image: url('images/mist.jpg');
        background-size: cover;

    }
    .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999; /* Ensure it's above other content */
        }

        .spinner {
            border: 6px solid #f3f3f3; /* Light grey */
            border-top: 6px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite; /* Rotate animation */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        function updateBackground(weatherIcon) {
            var iconClassMapping = {
                '01d': 'clear-sky-day',
                '01n': 'clear-sky-night',
                '02d': 'few-clouds-day',
                '02n': 'few-clouds-night',
                '03d': 'scattered-clouds-day',
                '03n': 'scattered-clouds-night',
                '04d': 'broken-clouds-day',
                '04n': 'broken-clouds-night',
                '09d': 'shower-rain-day',
                '09n': 'shower-rain-night',
                '10d': 'rain-day',
                '10n': 'rain-night',
                '11d': 'thunderstorm-day',
                '11n': 'thunderstorm-night',
                '13d': 'snow-day',
                '13n': 'snow-night',
                '50d': 'mist-day',
                '50n': 'mist-night'
            };
            var iconClass = iconClassMapping[weatherIcon] || 'default-background';
            document.body.classList.remove(...Object.values(iconClassMapping), 'default-background');
            document.body.classList.add(iconClass);
        }
        setTimeout(function () {
                document.body.className = iconClass;
            }, 500);
        window.onload = function() {
            var initialWeatherIcon = "@isset($data['weather'][0]['icon']){{ $data['weather'][0]['icon'] }}@else default @endisset";
            updateBackground(initialWeatherIcon);
        };
    </script>
</head>
<body class="@isset($data['weather'][0]['icon'])
{{ strtolower($data['weather'][0]['description']) }}-day @endisset">
    <div class="weather">
        <h1>Weather App</h1>

        <form action="{{ route('getWeather') }}" method="post">
            @csrf
            <label for="city">Enter city:</label>
            <input type="text" id="city" name="city" required>
            <button type="submit">Get Weather</button>
        </form>

        @isset($data['weather'][0]['icon'])
    @php
        // Mapping between OpenWeatherMap condition codes and Font Awesome icons
        $iconMapping = [
            '01d' => ['icon' => 'sun', 'color' => '#ffd700'],   // Clear sky (day)
            '01n' => ['icon' => 'moon', 'color' => '#ffffff'],  // Clear sky (night)
            '02d' => ['icon' => 'cloud-sun', 'color' => '#ffd700'],   // Few clouds (day)
            '02n' => ['icon' => 'cloud-moon', 'color' => '#ffffff'],  // Few clouds (night)
            '03d' => ['icon' => 'cloud', 'color' => '#8fa0b6'],  // Scattered clouds (day)
            '03n' => ['icon' => 'cloud', 'color' => '#8fa0b6'],  // Scattered clouds (night)
            '04d' => ['icon' => 'cloud', 'color' => '#8fa0b6'],  // Broken clouds (day)
            '04n' => ['icon' => 'cloud', 'color' => '#8fa0b6'],  // Broken clouds (night)
            '09d' => ['icon' => 'cloud-showers-heavy', 'color' => '#87ceeb'],  // Shower rain (day)
            '09n' => ['icon' => 'cloud-showers-heavy', 'color' => '#87ceeb'],  // Shower rain (night)
            '10d' => ['icon' => 'cloud-rain', 'color' => '#708090'],   // Rain (day)
            '10n' => ['icon' => 'cloud-rain', 'color' => '#708090'],   // Rain (night)
            '11d' => ['icon' => 'bolt', 'color' => '#ffa500'],   // Thunderstorm (day)
            '11n' => ['icon' => 'bolt', 'color' => '#ffa500'],   // Thunderstorm (night)
            '13d' => ['icon' => 'snowflake', 'color' => '#ffffff'],   // Snow (day)
            '13n' => ['icon' => 'snowflake', 'color' => '#ffffff'],   // Snow (night)
            '50d' => ['icon' => 'smog', 'color' => '#d3d3d3'],   // Mist (day)
            '50n' => ['icon' => 'smog', 'color' => '#d3d3d3'],   // Mist (night)
        ];
        // Get the corresponding Font Awesome icon and color for the current condition
        $weatherIconData = $iconMapping[$data['weather'][0]['icon']];
   // Temperature icon mapping based on weather condition
   $temperatureIconMapping = [
                    '01d' => 'fas fa-thermometer-half', // Clear sky (day)
                    '02d' => 'fas fa-thermometer-half', // Few clouds (day)
                    '03d' => 'fas fa-thermometer-half', // Scattered clouds (day)
                    '04d' => 'fas fa-thermometer-half', // Broken clouds (day)
                    '09d' => 'fas fa-thermometer-half', // Shower rain (day)
                    '10d' => 'fas fa-thermometer-half', // Rain (day)
                    '11d' => 'fas fa-thermometer-half', // Thunderstorm (day)
                    '13d' => 'fas fa-thermometer-half', // Snow (day)
                    '50d' => 'fas fa-thermometer-half', // Mist (day)
                    '01n' => 'fas fa-thermometer-half', // Clear sky (night)
                    '02n' => 'fas fa-thermometer-half', // Few clouds (night)
                    '03n' => 'fas fa-thermometer-half', // Scattered clouds (night)
                    '04n' => 'fas fa-thermometer-half', // Broken clouds (night)
                    '09n' => 'fas fa-thermometer-half', // Shower rain (night)
                    '10n' => 'fas fa-thermometer-half', // Rain (night)
                    '11n' => 'fas fa-thermometer-half', // Thunderstorm (night)
                    '13n' => 'fas fa-thermometer-half', // Snow (night)
                    '50n' => 'fas fa-thermometer-half', // Mist (night)
                ];

                // Get the corresponding temperature icon for the current weather condition
                $temperatureIcon = $temperatureIconMapping[$data['weather'][0]['icon']];
            @endphp

            <div class="weather-header">
                <i class="weather-icon fas fa-{{ $weatherIconData['icon'] }}" style="color: {{ $weatherIconData['color'] }}"></i>
                <h2>{{ $data['name'] }}, {{ $data['sys']['country'] }}</h2>
            </div>
            <p class="temp">
                <i class="temperature-icon {{ $temperatureIcon }}" style="color: {{ $weatherIconData['color'] }}"></i>
                <strong>{{ $data['main']['temp'] }}°C | {{ $data['weather'][0]['description'] }}</strong>
            </p>
        @endisset

        @isset($error)
            <p class="error">{{ $error }}</p>
        @endisset
    </div>
    <script>
        // Add the following JavaScript to dynamically update the background
        const body = document.querySelector('body');

        @isset($data['weather'][0]['icon'])
            const weatherIcon = '{{ $data['weather'][0]['icon'] }}';
            body.className = weatherIcon + '-day'; // Set the initial background based on the day condition
        @endisset
    </script>
</body>
</html>
