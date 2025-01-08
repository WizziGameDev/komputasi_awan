<?php
require_once "../repository/getAllData.php";
session_start();

// Check session
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$data = getAllPurchase();
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Purchase Supplier</title>

        <link rel="stylesheet" href="../assets/style/stylePurchase.css">
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
                <!-- Head -->
                <div class="header">
                    <h1>PURCHASE SUPPLIER</h1>
                </div>

                <!-- Controller -->
                <div class="controller">
                    <a href="viewAddPurchase.php" class="button-add">ADD PURCHASE</a>
                </div>

                <!-- START TABLE -->
                <div class="outer-wrapper">
                    <div class="table-wrapper">
                        <table>
                            <!-- Header -->
                            <tr>
                                <th>NO</th>
                                <th>DATE</th>
                                <th>SUPPLIER</th>
                                <th>QTY</th>
                                <th>T_PRICE</th>
                                <th class="change">ACTIONS</th>
                            </tr>

                            <!-- Value -->
                            <?php
                            $counter = 1;
                            foreach ($data as $purchase) { ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td><?= $purchase->getTglPurchase()?></td>
                                    <td><?= $purchase->getSupplierName()?></td>
                                    <td><?= $purchase->getQuantity()?></td>
                                    <td><?= $purchase->getTotalPrice()?></td>
                                    <td>
                                        <div class="button-control">
                                            <a href="viewDetailPurchase.php?id=<?=$purchase->getId()?>" class="button-detail">DETAIL</a>
                                            <a href="../repository/purchase_supplier/actionDeletePurchase.php?action_type=delete&id=<?= $purchase->getId() ?>" class="button-delete">DELETE</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $counter++;
                            } ?>
                        </table>
                    </div>
                </div>
                <!-- END TABLE-->
            </div>
            <!-- END CONTENT-->
        </div>
    </body>
</html>
