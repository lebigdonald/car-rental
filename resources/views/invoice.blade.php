<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $rent->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0;
            padding-bottom: 0;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            text-align: left;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        .btn-print {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }

        @media print {
            .btn-print {
                display: none;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-print">Imprimer la facture</button>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                CarRental
                            </td>

                            <td>
                                Facture #: {{ $rent->id }}<br>
                                Créée le: {{ \Carbon\Carbon::parse($rent->created_at)->format('d/m/Y') }}<br>
                                Échéance: {{ \Carbon\Carbon::parse($rent->start_date)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                CarRental Inc.<br>
                                1234 Rue de la Location<br>
                                Douala, Cameroun
                            </td>

                            <td>
                                {{ $rent->user->first_name }} {{ $rent->user->last_name }}<br>
                                {{ $rent->user->email }}<br>
                                {{ $rent->user->phone }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Méthode de paiement
                </td>

                <td>
                    Check #
                </td>
            </tr>

            <tr class="details">
                <td>
                    {{ $rent->payement_method }}
                </td>

                <td>
                    {{ $rent->payement_status }}
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Description
                </td>

                <td>
                    Prix
                </td>
            </tr>

            <tr class="item">
                <td>
                    Location de {{ $rent->car->brand }} {{ $rent->car->model }} ({{ \Carbon\Carbon::parse($rent->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($rent->end_date)->format('d/m/Y') }})
                </td>

                <td>
                    {{ number_format($rent->total_cost, 0, ',', ' ') }} FCFA
                </td>
            </tr>

            <tr class="total">
                <td></td>

                <td>
                   Total: {{ number_format($rent->total_cost, 0, ',', ' ') }} FCFA
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
