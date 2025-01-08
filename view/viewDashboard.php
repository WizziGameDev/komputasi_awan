<?php
require_once "../repository/getAllData.php";
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$totalSales = getTotalSales();
$totalPurchase = getTotalPurchase();
$totalCustomer = getTotalCustomer();
$totalSupplier = getTotalSupplier();
$dataSale = getRecentSale();
$dataPurchase = getRecentPurchase();

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="../assets/style/styleDashboard.css">
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div class="container">
            <!-- START NAV -->
            <div class="navigation">
                <nav class="sidebar">
                    <ul>
                        <li class="logo_app">
                            <img class="text_logo" src="../assets/image/logo.png" alt="text_logo">
                        </li>
                        <li>
                            <a href="viewDashboard.php">
                                <span class="material-icons">dashboard</span>
                                <span class="nav-name">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewSupplier.php">
                                <span class="material-icons">local_shipping</span>
                                <span class="nav-name">Supplier</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewItem.php">
                                <span class="material-icons">category</span>
                                <span class="nav-name">Item</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewSale.php">
                                <span class="material-icons">point_of_sale</span>
                                <span class="nav-name">Sale</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewPurchase.php">
                                <span class="material-icons">shopping_cart</span>
                                <span class="nav-name">Purchase</span>
                            </a>
                        </li>
                        <li>
                            <a href="../repository/logOut.php" class="btn-logout">
                                <span class="material-icons">logout</span>
                                <span class="nav-name">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- END NAV -->

            <!-- START CONTENT -->
            <div class="content-container">
                <section class="home-section">
                    <nav>
                        <div class="sidebar-button">
                            <span class="material-icons">dashboard</span>
                            <span class="dashboard"><?=$_SESSION['username']?></span>
                        </div>
                    </nav>

                    <div class="home-content">
                        <div class="overview-boxes">
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Sales</div>
                                    <div class="number"><?php echo $totalSales ?></div>
                                </div>
                                    <i class='bx bx-cart-alt cart one'></i>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Purchases</div>
                                    <div class="number"><?php echo $totalPurchase ?></div>
                                </div>
                                <i class='bx bxs-cart-add cart two' ></i>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Customers</div>
                                    <div class="number"><?php echo $totalCustomer ?></div>
                                </div>
                                <i class='bx bx-user cart three' ></i>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Suppliers</div>
                                    <div class="number"><?php echo $totalSupplier ?></div>
                                </div>
                                <i class='bx bx-user cart four' ></i>
                            </div>

                        </div>

                        <!-- SAlE -->
                        <div class="sales-boxes">
                            <h3>RECENT SALES</h3>
                            <div class="table-wrapper">
                                <table>
                                    <!-- Header -->
                                    <tr>
                                        <th>NO</th>
                                        <th>DATE</th>
                                        <th>CUSTOMER</th>
                                        <th>ACTIONS</th>
                                    </tr>

                                    <!-- Value -->
                                    <?php
                                    $counter = 1;
                                    foreach ($dataSale as $sale) { ?>
                                        <tr>
                                            <td><?= $counter ?></td>
                                            <td><?= $sale['tgl_sale'] ?></td>
                                            <td><?= $sale['customer_name']?></td>
                                            <td>NO</td>
                                        </tr>
                                        <?php $counter++;
                                    } ?>
                                </table>
                            </div>
                        </div>

                        <!-- PURCHASE -->
                        <div class="purchase-boxes">
                            <h3>RECENT PURCHASE</h3>
                            <div class="table-wrapper">
                                <table>
                                    <!-- Header -->
                                    <tr>
                                        <th>NO</th>
                                        <th>DATE</th>
                                        <th>SUPPLIER</th>
                                        <th>ACTIONS</th>
                                    </tr>

                                    <!-- Value -->
                                    <?php
                                    $counter = 1;
                                    foreach ($dataPurchase as $purchase) { ?>
                                        <tr>
                                            <td><?= $counter ?></td>
                                            <td><?= $purchase['tgl_purchase'] ?></td>
                                            <td><?= $purchase['supplier_name']?></td>
                                            <td>NO</td>
                                        </tr>
                                        <?php $counter++;
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- END CONTENT-->
        </div>

    <!-- JS -->
    </body>
</html>