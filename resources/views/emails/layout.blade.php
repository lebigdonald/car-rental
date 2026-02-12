<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6em;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }

        .header {
            background-color: #2F80ED;
            padding: 20px;
            text-align: center;
            color: white;
            border-radius: 5px 5px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .body {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
        }

        .footer a {
            color: #999;
            text-decoration: none;
        }

        h1, h2, h3 {
            color: #333;
        }

        p {
            margin-bottom: 20px;
            color: #555;
        }

        .btn {
            display: inline-block;
            background-color: #2F80ED;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list strong {
            color: #333;
        }
    </style>
</head>
<body>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container">
            <div class="content">
                <div class="header">
                    <!-- You can replace this text with an img tag if you have a hosted image -->
                    <h1>CarRental</h1>
                </div>
                <div class="body">
                    @yield('content')
                </div>
                <div class="footer">
                    <p>&copy; {{ date('Y') }} CarRental. Tous droits réservés.</p>
                    <p>
                        <a href="{{ route('home.index') }}">Visitez notre site</a> |
                        <a href="{{ route('contacts.show') }}">Contactez-nous</a>
                    </p>
                    <p>Douala, Cameroun</p>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
