<?php
require_once "../repository/getAllData.php";
session_start();

// Check session
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$data = getAllItem();
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Sale</title>

        <link rel="stylesheet" href="../assets/style/styleAddSale.css">
    </head>
    <body>

        <!-- CONTENT -->
        <div class="container">
            <div>
                <!-- HEAD -->
                <h1> CUSTOMER SALE </h1>
            </div>
            <div class="container-sale">
                <!--TABLE AND SALE -->
                <div class="item">
                    <!-- TABLE ITEM -->
                    <div class="outer-wrapper">
                        <h2> ITEM </h2>
                        <div class="table-wrapper">
                            <table>

                                <tr>
                                    <th>NO</th>
                                    <th>NAME</th>
                                    <th>SIZE</th>
                                    <th>PRICE /ITEM</th>
                                    <th width="20%">ACTIONS</th>
                                </tr>

                                <!-- LIST ITEM -->
                                <?php
                                $counter = 1;
                                foreach ($data as $item) {
                                    ?>
                                    <tr>
                                        <td><?= $counter ?></td>
                                        <td><?= $item->getName() ?></td>
                                        <td><?= $item->getSize() ?></td>
                                        <td><?= $item->getPrice() ?></td>
                                        <td>
                                            <div class="td-quantity">
                                                <a href="../repository/sale_customer/actionAddSale.php?action_type=remove_item&id=<?=$item->getId()?>&product_name=<?=$item->getName()?>&size=<?=$item->getSize()?>&quantity=1&price=<?=$item->getPrice()?>" class="min">
                                                    MIN
                                                </a>
                                                <a href="../repository/sale_customer/actionAddSale.php?action_type=add_item&id=<?=$item->getId()?>&product_name=<?=$item->getName()?>&size=<?=$item->getSize()?>&quantity=1&price=<?=$item->getPrice()?>" class="plus">
                                                    PLUS
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $counter++;
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="item-sale">
                    <h2> SALE </h2>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th width="20%">Qty</th>
                                <th width="30%">Total</th>
                            </tr>
                            </thead>

                            <!-- CART -->
                            <tbody>
                            <?php
                            $Total = 0;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $key => $cartItem) {
                                    $totalItem = $cartItem['price'] * $cartItem['quantity'];
                                    $Total += $totalItem;
                                    ?>
                                    <tr>
                                        <td style="padding: 5px"><?= $cartItem['product_name'] ?></td>
                                        <td><?= $cartItem['size'] ?></td>
                                        <td><?= $cartItem['quantity'] ?></td>
                                        <td><?= $totalItem ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="footer">
                <div class="close">
                    <a href="../repository/sale_customer/actionAddSale.php?action_type=clear_session" class="button-close">Close</a>
                </div>

                <div class="submit">
                    <label> Total = <?= $Total?></label>
                    <form method="POST" action="../repository/sale_customer/actionAddSale.php?action_type=submit" class="input-form">
                        <label>Customer <input name="customer_name"> </label>
                        <br>
                        <button class="button-submit" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        /* ERROR HANDLE*/
        if (isset($_SESSION['error_message'])) {
            $error_message = $_SESSION['error_message'];
            echo "<script>
                            alert('$error_message');
                        </script>";
            unset($_SESSION['error_message']);

        } elseif (isset($_SESSION['success_message'])) {
            $success_message = $_SESSION['success_message'];
            echo "<script>
                            alert('$success_message');
                        </script>";
            unset($_SESSION['success_message']);
        }
        ?>
    </body>
</html>
