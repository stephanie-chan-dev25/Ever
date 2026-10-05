<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket - Ever</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/panier.css">
    <script src="../assets/js/script.js" defer=""></script>
</head>
<body>
<nav>
    <img src="../assets/img/logo.svg" alt="Ever">
    <img class="black-hamburger" src="../assets/icon/bars-solid-full.svg" alt="menu hamburger">
    <img class="green-hamburger" src="../assets/icon/hamburger-vert.svg" alt="menu hamburger">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="recette.php">RECIPES</a></li>
            <li><a href="#">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
<main>
    <h1>Total : <?php echo $_SESSION["total"];?> MGA</h1>
    <div class="content-aliment-card">
        <?php
            for ($i=0; $i < count($_SESSION["ids"]); $i++) { 
        ?>
        <div href class="aliment-card">
            <a href="fiche.php?id=<?php echo $_SESSION["ids"][$i]?>"><img class="aliment-img" src="../assets/img/<?php echo $_SESSION["ids"][$i];?>.png" alt="<?php echo $row["nom"];?></"></a>
            <p class="aliment-card-name"><?php echo $_SESSION["noms"][$i];?></p>
            <p><?php echo $_SESSION["qtts"][$i];?> kg</p>
            <div class="bag-content">
                <p><?php echo $_SESSION["prix"][$i];?> MGA</p>
                <a href="#"><img src="../assets/img/sac-de-courses.png" alt="sac"></a>
            </div>
        </div>
        <?php
        }
        ?>
        </div>
        <a href="vider.php" class="btn">EMPTY THE BASKET</a>
    </main>
</body>
</html>