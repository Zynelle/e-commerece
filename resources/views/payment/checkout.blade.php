<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement Monetbil</title>
    <script type="text/javascript" src="https://fr.monetbil.com/widget/v2/monetbil.min.js"></script>
</head>
<body>
    <form action="{{ $paymentUrl }}" method="get" data-monetbil="form">
        <button type="submit" style="display: none;" id="monetbilButton">Payer</button>
    </form>

    <script>
        document.getElementById('monetbilButton').click();
    </script>
</body>
</html>
