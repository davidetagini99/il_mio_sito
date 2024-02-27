<?php

session_start();

require("conndb.php");

$query = "SELECT * FROM projectsbox";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="js/modal_control.js"></script>
    <title>Davide Tagini | portfolio</title>
</head>

<body>
    <main>
        <div class="projectstop">
            <h1>I miei progetti</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non repellat sint minus, excepturi qui,
                voluptatum earum illum mollitia eos esse sed architecto! Sint facilis aut corrupti excepturi, illum
                officia fugit.</p>
        </div>
        <div class="projectsbox">

            <?php
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h4>' . $row['project_title'] . '</h4>';
                echo '<img src="' . $row['project_image'] . '" alt="Avatar" style="width:100%">';
                echo '<div class="container">';
                echo '<button class="open-modal-btn" data-project-description="' . $row['project_description'] . '">Apri scheda</button>';
                echo '</div>';
                echo '</div>';
            }
            ?>

        </div>

        <!-- start modal -->

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="closebtncontainer">
                    <span class="close">&times;</span>
                </div>
                <div class="modal-subcontent">
                    <img id="modalImage" alt="Immagine progetto">
                    <p id="modalDescription"></p>
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <button type="submit">Valuta</button>
                    </form>
                    <a href="">Visita</a>
                </div>
            </div>

        </div>
        <!-- end modal -->

    </main>

    <script>
        var openModalBtns = document.querySelectorAll('.open-modal-btn');
        var modalImage = document.getElementById('modalImage');
        var modalDescription = document.getElementById('modalDescription');

        openModalBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                modalImage.src = btn.parentElement.previousElementSibling.src;
                modalDescription.textContent = btn.getAttribute('data-project-description');
                document.getElementById('myModal').style.display = 'block';
            });
        });

        var closeModalBtn = document.querySelector('.close');
        closeModalBtn.addEventListener('click', function () {
            document.getElementById('myModal').style.display = 'none';
        });
    </script>

</body>

</html>