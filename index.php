<?php include("page/connection.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Ever</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer=""></script>
</head>

<body>

    <nav>
        <img src="assets/img/logo.svg" alt="Ever">
        <img class="menu-icon-default" src="assets/icon/bars-solid-full.svg" alt="menu icon">
        <img class="menu-icon-active" src="assets/icon/hamburger-green.svg" alt="menu icon active">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="page/recipes.php">RECIPES</a></li>
                <li><a href="page/cart.php">BASKET</a></li>
                <li><a href="#contact">CONTACTS</a></li>
            </ul>
    </nav>

    <header>
        <div>
            <h1>Eat healthy and spend less</h1>
            <p>Choose a food to see its nutritional values and price</p>
            <button onclick="document.getElementById('down').scrollIntoView({behavior: 'smooth'});">FILL THE BASKET</button>
        </div>
    </header>

    <main id="down">
        <form method="GET" class="search-form">
            <input type="text" name="food" placeholder="Search for food" value="<?php echo isset($_GET['food']) ? htmlspecialchars($_GET['food']) : ''; ?>">
            <input type="submit" value="Validate">
        </form>
        <?php
        function isMobileDevice(): bool {
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            return (bool) preg_match('/Android|iPhone|iPad|iPod|IEMobile|Opera Mini|Mobile/i', $userAgent);
        }

        function buildPaginationUrl(int $targetPage, string $search = ''): string {
            $params = ['page' => $targetPage];
            if ($search !== '') {
                $params['food'] = $search;
            }
            return '?' . http_build_query($params);
        }

        function getVisiblePages(int $currentPage, int $totalPages): array {
            if ($totalPages <= 7) {
                return range(1, $totalPages);
            }

            $pages = [1];
            $start = max(2, $currentPage - 1);
            $end = min($totalPages - 1, $currentPage + 1);

            if ($start > 2) {
                $pages[] = '...';
            }

            for ($i = $start; $i <= $end; $i++) {
                $pages[] = $i;
            }

            if ($end < $totalPages - 1) {
                $pages[] = '...';
            }

            $pages[] = $totalPages;

            return $pages;
        }

        $limit = isMobileDevice() ? 4 : 8;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }

        $search = isset($_GET['food']) ? trim($_GET['food']) : '';
        $isSearch = $search !== '';

        if ($isSearch) {
            $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM food WHERE name = ?");
            $countStmt->bind_param("s", $search);
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = (int) ($countResult->fetch_assoc()['total'] ?? 0);
            $countStmt->close();
        } else {
            $totalResult = $conn->query("SELECT COUNT(*) AS total FROM food");
            $total = (int) ($totalResult->fetch_assoc()['total'] ?? 0);
        }

        $totalPages = max(1, (int) ceil($total / $limit));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $limit;

        if ($isSearch) {
            $dataStmt = $conn->prepare("SELECT id, name, quantity, price FROM food WHERE name = ? LIMIT ? OFFSET ?");
            $dataStmt->bind_param("sii", $search, $limit, $offset);
            $dataStmt->execute();
            $result = $dataStmt->get_result();
        } else {
            $dataStmt = $conn->prepare("SELECT id, name, quantity, price FROM food LIMIT ? OFFSET ?");
            $dataStmt->bind_param("ii", $limit, $offset);
            $dataStmt->execute();
            $result = $dataStmt->get_result();
        }
        ?>
        <div class="page-container">
            <div class="products-grid">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="product-card-item">
                            <a href="page/product.php?id=<?php echo $row["id"]; ?>">
                                <img class="product-image" src="assets/img/<?php echo $row["id"]; ?>.png" alt="<?php echo $row["name"]; ?>">
                            </a>
                            <p class="food-name"><?php echo $row["name"]; ?></p>
                            <p class="food-quantity"><?php echo $row["quantity"]; ?> kg</p>
                            <div class="food-meta">
                                <p class="food-price"><?php echo formatNumber($row["price"]); ?> MGA</p>
                                <a href="page/add-to-cart.php?id=<?php echo $row["id"]; ?>"><img class="cart-icon" src="assets/img/shopping-bag.png" alt="basket"></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>⚠ No result.</p>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a class="pagination-button" href="<?php echo buildPaginationUrl($page - 1, $search); ?>">PREVIOUS</a>
                    <?php endif; ?>

                    <?php if ($totalPages <= 2): ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="pagination-active"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a class="pagination-button" href="<?php echo buildPaginationUrl($i, $search); ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php else: ?>
                        <form method="GET" class="pagination-form">
                            <?php foreach ($_GET as $key => $value): ?>
                                <?php if ($key !== 'page'): ?>
                                    <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>">
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <select name="page" class="page-selector" onchange="this.form.submit()">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo $i === $page ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    <?php endif; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="pagination-button" href="<?php echo buildPaginationUrl($page + 1, $search); ?>">NEXT</a>
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
        <img src="assets/icon/mail.svg" alt="envelope">
        <p>STEPHANIE.CHAN.DEV@GMAIL.COM</p>
    </div>
    <div>
        <img src="assets/icon/phone-solid-full.svg" alt="phone">
        <p>(+261) 38 59 297 88</p>
    </div>
    <div>
        <img class="logo-ever" src="assets/img/logo.svg" alt="Ever">
    </div>
</footer>
</body>
</html>
