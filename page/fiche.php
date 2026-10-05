<?php include("connexion.php");?>
<?php
$id = $_GET["id"];
$sql = $conn->prepare("SELECT * FROM aliment WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc()
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File - Ever</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/fiche.css">
    <script src="../assets/js/script.js" defer=""></script>
</head>
<body class="content">
<nav>
    <img src="../assets/img/logo.svg" alt="Ever">
    <img class="black-hamburger" src="../assets/icon/bars-solid-full.svg" alt="menu hamburger">
    <img class="green-hamburger" src="../assets/icon/hamburger-vert.svg" alt="menu hamburger">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="recette.php">RECIPES</a></li>
            <li><a href="panier.php">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
    <a class="back" href="../index.php">
        <img class="black-back" src="../assets/icon/arrow-left-solid-full.svg" alt="flèche">
        <img class="green-back" src="../assets/icon/fleche-vert.svg" alt="flèche">
    </a>
    <img class="main-img" src="../assets/img/<?php echo $id;?>.png" alt="<?php echo $row["nom"]?>">
<div class="nutrients-content">
    <h1><?php echo $row["nom"]?></h1>
    <div class="nutrients-sub-content">
        <p><?php echo $row["qtt"]?> kg</p>
        <p><?php echo $row["prix"]?> MGA</p>
    </div>
    <div class="nutrients-sub-content-2">
        <?php
        $sql2 = $conn->prepare("SELECT n.nom AS nutriment, c.qtt
        FROM contenir c
        JOIN nutriment n ON c.nutriment_id = n.id
        WHERE c.aliment_id = ?");
        $sql2->bind_param("i", $id);
        $sql2->execute();
        $result2 = $sql2->get_result();
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
        ?>
            <div class="nutrients">
                <p><?php echo $row2['nutriment'];?></p>
                <p><?php echo $row2['qtt'];?> g</p>
            </div>
        <?php
            }
        } else {
            echo "Aucun nutriment trouvé pour cet aliment.";
        }
        ?>
    </div>
</div>
</body>
    
</html>