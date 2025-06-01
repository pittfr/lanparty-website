<!DOCTYPE html>
<html lang="pt-pt">

<?php
    require_once "includes/functions.php";
    require_once "includes/connect.php";
    require_once "includes/login.php";

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
            case "login":
                $page = "login";
                break;
            default:
                $page = "home";
                break;
        }
    } else {
        $page = "home";
    }

    
    $pageSpecificCSS = [];
    $pageSpecificJS = [];
    
    switch($page) {
        case "home":
            $pageSpecificCSS[] = "css/home.css";
            $pageSpecificJS[] = "js/countdown.js";
            $pageSpecificJS[] = "js/load-featured-games.js";

            $eventDateQuery = $db->query("SELECT valor FROM definicoes WHERE chave='lanparty_data'");
            
            if($eventDateQuery && $eventDateQuery->num_rows > 0){
                $eventDate = $eventDateQuery->fetch_assoc()['valor'];
            }
            break;
        case "torneios":
            $pageSpecificCSS[] = "css/torneios.css";
            break;
        case "staff":
            $pageSpecificCSS[] = "css/staff.css";
            $pageSpecificJS[] = "js/staff.js";
            break;
        case "login":
            $pageSpecificCSS[] = "css/user_login.css";
            break;
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($page); ?></title>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    
    <?php foreach($pageSpecificCSS as $css): ?>
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>
    
    <script src="js/nav.js" defer></script>

    <script>
        const EVENT_DATE = "<?php echo $eventDate;?>";
    </script>
    
    <?php foreach($pageSpecificJS as $js): ?>
    <script src="<?php echo $js; ?>" defer></script>
    <?php endforeach; ?>
</head>
<body>
    
    <?php
        require "header.php";
    ?>
    <ul id="user-messages">
        <?php
            // echo msgSuccess("Tarefa realizada com sucesso!");
            // echo msgWarning("Tarefa realizada com aviso!");
            // echo msgError("Tarefa realizada com erro!");
        ?>
    </ul>
        
    <?php
        include "includes/navsystem.php";
        
        require "footer.php";
    ?>

</body>

<?php
    $db->close();
?>

</html>