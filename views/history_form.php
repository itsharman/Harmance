<table class="table table-striped">

    <thead>
        <tr>
            <th>Transaction</th>
            <th>Date/Time</th>
            <th>Symbol</th>
            <th>Shares</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($history as $table): ?>
        <tr>
            <td><?= $table["transaction"] ?></td>
            <td><?= $table["date_time"] ?></td>
            <td><?= $table["symbol"] ?></td>
            <td><?= $table["shares"] ?></td>
            <td><?= '$'.number_format($table["price"], 2) ?></td>
        </tr>
        <?php endforeach ?>    
    </tbody>

</table>