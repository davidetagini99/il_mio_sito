<?php
session_start();

require("conndb.php");

// Check if the user has voted
if (!isset($_SESSION['has_voted']) || !$_SESSION['has_voted']) {
    // Redirect the user back to the portfolio page or any other appropriate page
    header("Location: portfolio.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Davide Tagini | valutazione</title>
</head>

<body>
    <main>
        <div class="generalvotecontainer">
            <div class="insidevotecontainer">
                <h1>
                    Congratulazioni
                </h1>
                <p>
                    Grazie per avere contribuito a questo progetto.
                </p>
                <div class="backtoprogetticontainer">
                    <a href="portfolio.php">Torna a progetti</a>
                </div>

            </div>

        </div>
    </main>
</body>

</html>