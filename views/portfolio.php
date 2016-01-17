<table class="table table-striped">

    <thead>
        <tr>
            <th>Name</th>
            <th>Symbol</th>
            <th>Shares</th>
            <th>Price Per Stock</th>
            <th>Total Value</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($positions as $position): ?>
        <tr>
            <th><?= $position["name"] ?></th>
            <th><?= $position["symbol"] ?></th>
            <th><?= $position["shares"] ?></th>
            <th><?= '$'.$position["price_per_stock"] ?></th>
            <th><?= '$'.number_format($position["total_price"], 2) ?></th>
        </tr>
        <?php endforeach ?>
        
        <tr>
            <th>CASH</th>
            <td></td>
            <td></td>
            <td></td>
            <th><?= '$'.number_format($cash[0]["cash"], 2) ?></th>
        </tr>
    </tbody>

</table>
          