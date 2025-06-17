<!-- resources/views/stkpush.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Pesa STK Push</title>
</head>
<body>
    <h1>Initiate M-Pesa STK Push</h1>

    <form action="{{ route('mpesa.initiate') }}" method="POST">
        @csrf

        <label for="amount">Amount (Ksh)</label><br>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="contact">Phone Number</label><br>
        <input type="tel" id="contact" name="contact" required><br><br>

        <button type="submit">Initiate Payment</button>
    </form>
</body>
</html>
