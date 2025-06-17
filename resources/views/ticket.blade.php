<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 10px; /* Adjust to fit content */
        }
        .container {
            width: 50%; /* Take half of the width of A4 */
            height: 25%; /* 1/4th of the A4 page */
            padding: 10px;
            border: 1px solid #000;
        }
        .header {
            text-align: left;
            margin-bottom: 10px;
        }
        .logo {
            width: 50px; /* Adjust logo size */
            height: auto;
            float: left;
        }
        .details {
            margin-top: 10px;
            float: left;
            width: 60%;
        }
        .qr-code {
            float: right;
            width: 30%;
        }
        .clear {
            clear: both;
        }
        .ticket-info {
            font-size: 8px; /* Smaller font for details */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('logo.png') }}" alt="Logo" class="logo"> <!-- Insert logo image here -->
            <div class="clear"></div>
        </div>
        
        <div class="details ticket-info">
            <p><strong>Passenger Name:</strong> {{ $ticketData['passenger_name'] }}</p>
            <p><strong>Flight Number:</strong> {{ $ticketData['flight_number'] }}</p>
            <p><strong>Departure:</strong> {{ $ticketData['departure'] }}</p>
            <p><strong>Arrival:</strong> {{ $ticketData['arrival'] }}</p>
            <p><strong>Departure Time:</strong> {{ $ticketData['departure_time'] }}</p>
            <p><strong>Arrival Time:</strong> {{ $ticketData['arrival_time'] }}</p>
            <p><strong>Seat:</strong> {{ $ticketData['seat'] }}</p>
            <p><strong>Gate:</strong> {{ $ticketData['gate'] }}</p>
            <p><strong>Ticket Number:</strong> {{ $ticketData['ticket_number'] }}</p>
        </div>

        <div class="qr-code">
            <img src="data:image/png;base64,{{ $barcodeImage }}" alt="QR Code"> <!-- QR Code -->
        </div>

        <div class="clear"></div>
    </div>
</body>
</html>

<!---http://127.0.0.1:8000/generate-ticket
-->