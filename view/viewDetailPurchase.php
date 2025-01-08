<?php
require_once "../repository/connection.php";
session_start();

// Check session
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$purchase_id = $_GET['id'];

$query = "SELECT 
        supplier.name AS supplier_name,
        detail_purchase.item_id,
        item.name AS item_name,
        item.size AS item_size,
        detail_purchase.price,
        detail_purchase.quantity,
        detail_purchase.total_price
    FROM 
        detail_purchase
    INNER JOIN 
        purchase ON detail_purchase.purchase_id = purchase.id
    INNER JOIN 
        supplier ON purchase.supplier_id = supplier.id
    INNER JOIN 
        item ON detail_purchase.item_id = item.id
    WHERE 
        purchase.id = ?
";

$connection = getConnection();
$statement = $connection->prepare($query);
$statement->execute([$purchase_id]);
$result = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Purchase</title>

        <link rel="stylesheet" href="../assets/style/styleDetailPurchase.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>DETAIL PURCHASE</h1>
            </div>
            <div class="name-user">
                <h3>Supplier : <?=$result[0]['supplier_name']?></h3>
            </div>
            <!-- START TABLE -->
            <div class="outer-wrapper">
                <div class="table-wrapper">
                    <table>
                        <!-- Header -->
                        <tr>
                            <th>NAME ITEM</th>
                            <th>SIZE</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>T_PRICE</th>
                        </tr>

                        <!-- Value -->
                        <?php
                            $total = 0;
                            foreach ($result as $row) { ?>
                                <tr>
                                    <td><?= $row['item_name'] ?></td>
                                    <td><?= $row['item_size'] ?></td>
                                    <td><?= $row['price'] ?></td>
                                    <td><?= $row['quantity'] ?></td>
                                    <td><?= $row['total_price'] ?></td>
                                </tr>
                            <?php $total+= $row['total_price'];
                        } ?>
                    </table>
                </div>
            </div>
            <!-- END TABLE -->
            <div class="total">
                <h3>Total : <?= $total ?></h3>
                <a href="viewPurchase.php" class="btn-close">CLOSE</a>
            </div>
        </div>
    </body>
</html>
