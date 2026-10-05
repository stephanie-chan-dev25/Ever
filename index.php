<?php include("page/connexion.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Ever</title>
    <link rel="stylesheet" href="assets/css/recette.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer=""></script>
</head>

<body>

    <nav>
        <img src="assets/img/logo.svg" alt="Ever">
        <img class="black-hamburger" src="assets/icon/bars-solid-full.svg" alt="menu hamburger">
        <img class="green-hamburger" src="assets/icon/hamburger-vert.svg" alt="menu hamburger">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="page/recette.php">RECIPES</a></li>
                <li><a href="page/panier.php">BASKET</a></li>
                <li><a href="#contact">CONTACTS</a></li>
            </ul>
    </nav>

    <header>
        <div>
            <h1>Eat healthy and spend less</h1>
            <p>Choose a food to see its nutritional values ans price</p>
            <button onclick="document.getElementById('down').scrollIntoView({behavior: 'smooth'});">FILL THE BASKET</button>
        </div>
    </header>

    <main id="down">
        <form method="GET">
            <input type="text" name="aliment" placeholder="Search for food" value="<?php echo isset($_GET['aliment']) ? htmlspecialchars($_GET['aliment']) : ''; ?>">
            <input type="submit" value="Valider">
        </form>
        <?php
        function isMobileDevice(): bool {
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            return (bool) preg_match('/Android|iPhone|iPad|iPod|IEMobile|Opera Mini|Mobile/i', $userAgent);
        }

        function buildPaginationUrl(int $targetPage, string $search = ''): string {
            $params = ['page' => $targetPage];
            if ($search !== '') {
                $params['aliment'] = $search;
            }
            return '?' . http_build_query($params);
        }

        $limit = isMobileDevice() ? 1 : 3;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }

        $search = isset($_GET['aliment']) ? trim($_GET['aliment']) : '';
        $isSearch = $search !== '';

        if ($isSearch) {
            $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM aliment WHERE nom = ?");
            $countStmt->bind_param("s", $search);
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = (int) ($countResult->fetch_assoc()['total'] ?? 0);
            $countStmt->close();
        } else {
            $totalResult = $conn->query("SELECT COUNT(*) AS total FROM aliment");
            $total = (int) ($totalResult->fetch_assoc()['total'] ?? 0);
        }

        $totalPages = max(1, (int) ceil($total / $limit));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $limit;

        if ($isSearch) {
            $dataStmt = $conn->prepare("SELECT * FROM aliment WHERE nom = ? LIMIT ? OFFSET ?");
            $dataStmt->bind_param("sii", $search, $limit, $offset);
            $dataStmt->execute();
            $result = $dataStmt->get_result();
        } else {
            $dataStmt = $conn->prepare("SELECT * FROM aliment LIMIT ? OFFSET ?");
            $dataStmt->bind_param("ii", $limit, $offset);
            $dataStmt->execute();
            $result = $dataStmt->get_result();
        }
        ?>
        <div class="conteneur">
            <div class="content-aliment-card">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="aliment-card">
                            <a href="page/fiche.php?id=<?php echo $row["id"]; ?>">
                                <img class="aliment-img" src="assets/img/<?php echo $row["id"]; ?>.png" alt="<?php echo $row["nom"]; ?>">
                            </a>
                            <p class="aliment-card-name"><?php echo $row["nom"]; ?></p>
                            <p><?php echo $row["qtt"]; ?> kg</p>
                            <div class="bag-content">
                                <p><?php echo $row["prix"]; ?> MGA</p>
                                <a href="page/ajout.php?id=<?php echo $row["id"]; ?>"><img src="assets/img/sac-de-courses.png" alt="sac"></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>⚠ Aucun résultat.</p>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a class="pagination-link" href="<?php echo buildPaginationUrl($page - 1, $search); ?>">PREVIOUS</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i === $page): ?>
                            <span class="pagination-current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a class="pagination-link" href="<?php echo buildPaginationUrl($i, $search); ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="pagination-link" href="<?php echo buildPaginationUrl($page + 1, $search); ?>">NEXT</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $dataStmt->close();
        $conn->close();
        ?>
    </main>
<footer id="contact">
    <div>
        <img src="assets/icon/mail.svg" alt="enveloppe">
        <p>stephanie.chan.dev@gmail.com</p>
    </div>
    <div>
        <img src="assets/icon/phone-solid-full.svg" alt="téléphone">
        <p>(+261) 38 59 297 88</p>
    </div>
    <div>
        <img src="assets/img/logo.svg" alt="Ever">
    </div>
</footer>
</body>
</html>
