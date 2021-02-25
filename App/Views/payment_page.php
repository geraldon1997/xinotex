<h1 class="dash-title">Deposit with Cryptocurrency to <?= APP_NAME; ?> </h1>

<form action="" method="post">
    <label for="amountcurrency">Amount (USD)</label>
    <h1><?= number_format($params[0]['entered_amount']); ?></h1>
    <br>
    <label for="amountcoin">Amount (<?= $params[0]['to_currency'] ?>)</label>
    <h1><?= $params[0]['amount'].$params[0]['to_currency'] ?></h1>
    <a href="<?= $params[0]['gateway_url'] ?>" target="_blank" class="btn btn-primary btn-sm">pay now</a>
</form>

