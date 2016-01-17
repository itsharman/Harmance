<?php

    //configuration
    require("../includes/config.php"); 
    
    //if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //look up stock symbol on Yahoo (if inputted and valid)
        if (!empty($_POST["symbol"])) {
            $stock = lookup($_POST["symbol"]);
            if ($stock === false) {
                apologize("Please provide a valid stock symbol.");
            }
        }
        //ensure that symbol is not empty
        if (empty($_POST["symbol"])) {
            apologize("Please provide a stock symbol to search for.");
        }
        //ensure that share is not empty
        if (empty($_POST["shares"])) {
            apologize("Please provide an amount of shares.");
        }
        //ensure that share is a non-negative number
        if (preg_match("/^\d+$/", $_POST["shares"]) == false) {
            apologize("Please enter a non-negative integer.");
        }
        //calculate buying value (price of stock * shares)
        $value = $stock["price"] * $_POST["shares"];
        // The following three lines give me some unidentified index notification.
        // I don't know what it means.
        $balance = CS50::query ("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
        //if balance is less than the value, don't proceed
        if ($balance < $value) {
            apologize("Insufficient funds.");
        }
        //proceed if user has enough money to buy stocks
        else{
            //insert a new row into table unless the specified pair of id and symbol already exists in some row, in which case that row’s number of shares will simply be increased
            CS50::query ("INSERT INTO portfolios (user_id, symbol, shares) VALUES(?, ?, ?) 
            ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], strtoupper($stock["symbol"]), $_POST["shares"]);
            //update user's cash with sale value
            CS50::query ("UPDATE users SET cash = cash - ? WHERE id = ?", $value, $_SESSION["id"]);
        }
        //log history
        $log = CS50::query ("INSERT INTO history (user_id, transaction, date_time, symbol, shares, price) VALUES (?, 'BUY', NOW(), ?, ?, ?)",
        $_SESSION["id"], strtoupper($stock["symbol"]), $_POST["shares"], $stock["price"]);
        //redirect to index.php
        redirect("/index.php");
    }
    
    else {
        //render buy form
        render("buy_form.php", ["title" => "Buy"]);
    }
?>
