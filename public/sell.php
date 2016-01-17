<?php

    //configuration
    require("../includes/config.php"); 
    
    //if user reached page via POST (as by submitting a form via GET)
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //query symbol from portfolio
        $symbols = CS50::query ("SELECT symbol FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
        //if nothing to sell, apologize
        if ($symbols === false) apologize("Nothing to sell");
        //else render sell form
        else render("sell_form.php", ["title" => "Sell", "symbols" => $symbols]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST"){
        //look up stock symbol on Yahoo
        $stock = lookup($_POST["symbol"]);
        //look up stocks to be sold
        $shares = CS50::query("SELECT shares FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        //if found, calculate sale value
        if (count($shares) == 1) $shareValue = $shares[0]["shares"];
        else apologize("Shares not found.");
        $saleValue = $shareValue * $stock["price"];
        //update user's portfolio (remove stocks)
        CS50::query ("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        //update user's cash with sale value
        CS50::query ("UPDATE users SET cash = cash + ? WHERE id = ?", $saleValue, $_SESSION["id"]);
        //log history
        $log = CS50::query ("INSERT INTO history (user_id, transaction, date_time, symbol, shares, price) VALUES (?, 'SELL', Now(), ?, ?, ?)",
        $_SESSION["id"], strtoupper($stock["symbol"]), $shares[0]["shares"], $stock["price"]);
        //redirect to index.php
        redirect("/index.php");

    }
?>
