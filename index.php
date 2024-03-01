<?php
session_start();

require("conndb.php");

// Function to fetch text for the website from the database
function fetchTextForWebsite($conn)
{
    $query = "SELECT * FROM text_site";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error fetching text for the website: " . mysqli_error($conn));
    }

    return mysqli_fetch_assoc($result);
}

// Function to fetch menu items from the database
function fetchMenuItems($conn)
{
    $query = "SELECT * FROM menu_items";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error fetching menu items: " . mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to generate the navigation HTML dynamically
function generateNavigation($menuItems)
{
    $navigationHTML = '<div class="navdiv">
                <nav>
                    <ul>
                        <li>
                            <div class="icon-list">';

    foreach ($menuItems as $menuItem) {
        $navigationHTML .= '<div class="icon-list-box">
                        <a href="' . htmlspecialchars($menuItem['url'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($menuItem['label'], ENT_QUOTES, 'UTF-8') . '</a>
                    </div>';
    }

    $navigationHTML .= '</div>
                </li>
            </ul>
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa-solid fa-xmark"></i></a>
                <div class="globalinsidenav">';

    foreach ($menuItems as $menuItem) {
        $navigationHTML .= '<div class="injectsidenav">
                        <a href="' . htmlspecialchars($menuItem['url'], ENT_QUOTES, 'UTF-8') . '" onclick="closeNav()"><span>' . htmlspecialchars($menuItem['label'], ENT_QUOTES, 'UTF-8') . '</span></a>
                    </div>';
    }

    $navigationHTML .= '</div>
            </div>
            <span onclick="openNav()"><i class="fa fa-bars"></i></span>
        </nav>
    </div>';

    return $navigationHTML;
}

// Fetch menu items from the database
$menuItems = fetchMenuItems($conn);

// Fetch text for the website from the database
$textForWebsite = fetchTextForWebsite($conn);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="js/navbar_control.js"></script>
    <title>Davide Tagini</title>
</head>

<body>
    <main>
        <?php
        // Output the navigation component directly without using htmlspecialchars
        echo generateNavigation($menuItems);
        ?>

        <!-- start hero -->
        <div class="hero-image">
            <!-- add main content here -->
            <div class="hero-container">
                <h3>
                    <?php echo htmlspecialchars($textForWebsite['hero_text'], ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <div class="stuff-container">
                    <a href="<?php echo htmlspecialchars($textForWebsite['github_link'], ENT_QUOTES, 'UTF-8'); ?>"
                        target="_blank">
                        <?php echo htmlspecialchars($textForWebsite['github_link_text'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </div>
            </div>
        </div>
        <!-- end hero -->

        <!-- start about -->
        <div class="about-section" id="aboutMe">
            <h1>
                <?php echo htmlspecialchars($textForWebsite['about_text_1'], ENT_QUOTES, 'UTF-8'); ?>
            </h1>
            <div class="inside-aboutme">
                <p class="firstattendent">
                    <?php echo htmlspecialchars($textForWebsite['about_title_1'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <p class="secondattendent">
                    <?php echo htmlspecialchars($textForWebsite['about_text_2'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>
        </div>
        <!-- end about -->
    </main>

    <!-- Your other scripts and content go here -->
</body>

</html>