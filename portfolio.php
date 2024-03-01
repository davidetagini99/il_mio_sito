<?php
session_start();
require("conndb.php");

$query = "SELECT * FROM projectsbox";
$result = $conn->query($query);

if (isset($_POST["sendvotebtn"])) {
    $project_id = $_POST["project_id"];
    $vote_value = $_POST["vote_value"];
    $user_ip = $_SERVER["REMOTE_ADDR"];

    // Validate vote value
    if ($vote_value >= 1 && $vote_value <= 5) {
        // Check if project_id is not empty and is numeric
        if (!empty($project_id) && is_numeric($project_id)) {
            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO project_votes (project_id, user_ip, vote_value) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $project_id, $user_ip, $vote_value);

            // Execute the prepared statement
            $stmt->execute();

            // Check for success
            if ($stmt->affected_rows > 0) {
                // Vote inserted successfully
                $_SESSION['has_voted'] = true; // Set session variable to indicate that the user has voted
                header("Location: submit_vote.php");
                exit();
            } else {
                // Display MySQL error message
                echo "Error: " . $conn->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // Invalid project ID
            echo "Invalid project ID";
        }
    } else {
        // Invalid vote value
        echo "Invalid vote value";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Davide Tagini | portfolio</title>
</head>

<body>
    <main>
        <style>
            /* Add these styles for modal animation */
            .modal-content {
                animation: fadeInOut 0.5s ease-in-out;
            }

            @keyframes fadeInOut {
                from {
                    opacity: 0;
                    transform: translateY(-50%);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <div class="projectstop">
            <h1>I miei progetti</h1>
        </div>
        <div class="projectsbox">

            <?php
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h4>' . htmlspecialchars($row['project_title']) . '</h4>';
                echo '<img src="' . htmlspecialchars($row['project_image']) . '" alt="Avatar" style="width:100%">';
                echo '<div class="container">';
                echo '<button class="open-modal-btn" data-project-description="' . htmlspecialchars($row['project_description']) . '">Apri scheda</button>';

                // Check if project_link is not null before echoing it
                if ($row['project_link'] !== null) {
                    echo '<p class="project-link"><a href="' . htmlspecialchars($row['project_link']) . '" target="_blank">Visita</a></p>';
                } else {
                    echo '<p class="project-link">No link available</p>';
                }

                // Add hidden input for project ID in the vote form
                echo '<input type="hidden" class="project-id-input" value="' . htmlspecialchars($row['project_id']) . '">';

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
                    <button type="button" onclick="openVoteForm()">Valuta</button>
                    <p id="modalLink"></p>
                </div>
            </div>

        </div>
        <!-- end modal -->

        <!-- Vote Form Modal -->
        <div id="voteFormModal" class="modal">
            <div class="modal-content">
                <div class="modal-heading">
                    <h2>Valuta il progetto</h2>
                    <span class="close" onclick="closeVoteForm()">&times;</span>

                </div>
                <form action="portfolio.php" method="post">
                    <input type="hidden" id="projectIdInput" name="project_id" value="">
                    <label for="vote_value">Voto (da 1 a 5): </label>
                    <input type="number" id="voteInput" name="vote_value" min="1" max="5" required>
                    <div class="sendvotebtncontainer">
                        <button type="submit" name="sendvotebtn">Invia voto</button>
                    </div>

                </form>
            </div>
        </div>

    </main>

    <script>
        // Declare functions globally
        function openVoteForm() {
            var voteFormModal = document.getElementById('voteFormModal');
            voteFormModal.style.display = 'block';
            // Remove existing animation, if any
            voteFormModal.style.animation = 'none';
            setTimeout(() => {
                voteFormModal.style.animation = 'fadeInOut 0.5s ease-in-out';
            }, 10); // Small delay to allow display property to take effect
        }

        function closeVoteForm() {
            var voteFormModal = document.getElementById('voteFormModal');
            voteFormModal.style.animation = 'fadeInOut 0.5s ease-in-out';
            setTimeout(() => {
                voteFormModal.style.display = 'none';
            }, 500); // Wait for the animation to complete before hiding the modal
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('myModal').style.display = 'none';
            document.getElementById('voteFormModal').style.display = 'none';

            var openModalBtns = document.querySelectorAll('.open-modal-btn');
            var modalImage = document.getElementById('modalImage');
            var modalDescription = document.getElementById('modalDescription');
            var modalLink = document.getElementById('modalLink');
            var projectIdInput = document.getElementById('projectIdInput');

            openModalBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    modalImage.src = btn.parentElement.previousElementSibling.src;
                    modalDescription.textContent = btn.getAttribute('data-project-description');
                    modalLink.innerHTML = btn.nextElementSibling ? btn.nextElementSibling.innerHTML : '';

                    // Set the project_id in the hidden input
                    projectIdInput.value = btn.parentElement.querySelector('.project-id-input').value;

                    document.getElementById('myModal').style.display = 'block';
                });
            });

            var closeModalBtn = document.querySelector('.close');
            closeModalBtn.addEventListener('click', function () {
                document.getElementById('myModal').style.display = 'none';
            });
        });
    </script>



</body>

</html>