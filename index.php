<!DOCTYPE html>
<html lang="pt-pt">

<?php
    if(isset($_GET['page'])){
        switch ($_GET['page']){
            case "home":
                $page = "home";
                break;
            case "torneios":
                $page = "torneios";
                break;
            case "staff":
                $page = "staff";
                break;
            default:
                $page = "home";
                break;
        }
    } else {
        $page = "home";
    }

    require "includes/functions.php";
    
    $pageSpecificCSS = [];
    $pageSpecificJS = [];
    
    switch($page) {
        case "home":
            $pageSpecificCSS[] = "css/home.css";
            $pageSpecificJS[] = "js/countdown.js";
            $pageSpecificJS[] = "js/load-featured-games.js";
            break;
        case "torneios":
            $pageSpecificCSS[] = "css/torneios.css";
            break;
        case "staff":
            $pageSpecificCSS[] = "css/staff.css";
            $pageSpecificJS[] = "js/staff.js";
            break;
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($page); ?></title>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    
    <?php foreach($pageSpecificCSS as $css): ?>
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>
    
    <script src="js/nav.js" defer></script>
    
    <?php foreach($pageSpecificJS as $js): ?>
    <script src="<?php echo $js; ?>" defer></script>
    <?php endforeach; ?>
</head>
<body>
    
    <?php
        require "header.php";

        include "includes/navsystem.php";

        require "footer.php";
    ?>

</body>
</html>