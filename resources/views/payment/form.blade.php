<!DOCTYPE html>
<html>
<head>
    <title>Paiement Monetbil</title>
</head>
<body>
    <h1>Payer avec Monetbil</h1>
    <form action="{{ url('/payment/start') }}" method="POST">
        @csrf
        <label>Montant (XAF)</label>
        <input type="number" name="amount" value="500" required>
        <button type="submit">Payer</button>
    </form>
</body>
</html>
