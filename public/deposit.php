<?php

    //configuration
    require("../includes/config.php"); 
    
    //if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //ensure that share is a non-negative whole-number amount
        if (preg_match("/^\d+$/", $_POST["deposit"]) === false) {
            apologize("Please enter a non-negative amount.");
        }
        //update user's balance with new deposit
        CS50::query ("UPDATE users SET cash = cash + ? WHERE id = ?", $_POST["deposit"], $_SESSION["id"]);
        //log history
        $log = CS50::query ("INSERT INTO history (user_id, transaction, date_time, symbol, shares, price) VALUES (?, 'DEP', NOW(), 'N/A', ?, ?)",
        $_SESSION["id"], 1, $_POST["deposit"]);
        //redirect to index.php
        redirect("/index.php");
    }
    
    else {
        //render sell form
        render("deposit_form.php", ["title" => "Deposit"]);
    }
?>
