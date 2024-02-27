<?php
session_start();

require("conndb.php");
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
        // Assuming you have a database connection established
        
        // Function to fetch text for the website from the database
        function fetchTextForWebsite($conn)
        {
            $query = "SELECT * FROM text_site";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error fetching text for the website: " . mysqli_error($conn));
            }

            return mysqli_fetch_assoc($result);
        }

        // Function to fetch menu items from the database
        function fetchMenuItems($conn)
        {
            $query = "SELECT * FROM menu_items";
            $result = mysqli_query($conn, $query);

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
                                <a href="' . $menuItem['url'] . '"><span>' . $menuItem['label'] . '</span></a>
                            </div>';
            }

            $navigationHTML .= '</div>
                        </li>
                    </ul>
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="globalinsidenav">';

            foreach ($menuItems as $menuItem) {
                $navigationHTML .= '<div class="injectsidenav">
                                <a href="' . $menuItem['url'] . '"><span>' . $menuItem['label'] . '</span></a>
                            </div>';
            }

            $navigationHTML .= '</div>
                    </div>
                    <span style="font-size:20px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i></span>
                </nav>
            </div>';

            return $navigationHTML;
        }

        // Fetch text for the website from the database
        $textForWebsite = fetchTextForWebsite($conn);

        // Fetch menu items from the database
        $menuItems = fetchMenuItems($conn);

        // Generate navigation HTML
        $navigationComponent = generateNavigation($menuItems);

        // Output the navigation component
        echo $navigationComponent;

        ?>


        <!-- start hero -->
        <div class="hero-image">
            <!-- add main content here -->
            <div class="hero-container">
                <h3>
                    <?php echo $textForWebsite['hero_text']; ?>
                </h3>
                <div class="stuff-container">
                    <a href="<?php echo $textForWebsite['github_link']; ?>" target="_blank">
                        <?php echo $textForWebsite['github_link_text']; ?>
                    </a>
                </div>
            </div>
        </div>
        <!-- end hero -->

        <!-- start about -->
        <div class="about-section" id="aboutMe">
            <h1>
                <?php echo $textForWebsite['about_title_1']; ?>
            </h1>
            <div class="inside-aboutme">
                <p class="firstattendent">
                    <?php echo $textForWebsite['about_text_1']; ?>
                </p>
                <p>
                    <?php echo $textForWebsite['about_text_2']; ?>
                </p>
            </div>
        </div>
        <!-- end about -->
    </main>

</body>

</html>