<?php
require_once "../repository/getAllData.php";
session_start();

// Check session
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$data = getAllSupplier();
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Supplier</title>

        <link rel="stylesheet" href="../assets/style/styleSupplier.css">    
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
                    <h1>SUPPLIER MANAGEMENT</h1>
                </div>

                <!-- Controller -->
                <div class="controller">
                    <a href="#" class="button-add">ADD SUPPLIER</a>
                </div>

                <!-- START POP UP ADD -->
                <div class="popup-add">
                    <div class="popup-content">
                        <h1> ADD DATA SUPPLIER </h1>
                        <form method="POST" action="../repository/supplier/addSupplier.php" class="form-popup">
                            <div class="input-form">
                                <label>Name</label>
                                <input type="text" id="add-name-input" class="input" name="name">
                            </div>
                            <div class="input-form">
                                <label>Email</label>
                                <input type="text" id="add-email-input" class="input" name="email">
                            </div>
                            <div class="input-form">
                                <label>Contact</label>
                                <input type="text" id="add-contact-input" class="input" name="contact">
                            </div>
                            <div class="input-form">
                                <label>Address</label>
                                <input type="text" id="add-address-input" class="input" name="address">
                            </div>
                            <div class="button-form">
                                <a href="#" class="btn-close"> CLOSE </a>
                                <button type="submit" class="btn-submit"> SUBMIT </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END POP UP ADD -->

                <!-- START POP UP EDIT -->
                <div class="popup-edit">
                    <div class="popup-content">
                        <h1> EDIT DATA SUPPLIER </h1>
                        <form method="POST" action="../repository/supplier/editSupplier.php" class="form-popup">
                            <input type="hidden" id="edit-id-input" name="id">
                            <div class="input-form">
                                <label>Name</label>
                                <input type="text" id="edit-name-input" class="input" name="name">
                            </div>
                            <div class="input-form">
                                <label>Email</label>
                                <input type="text" id="edit-email-input" class="input" name="email">
                            </div>
                            <div class="input-form">
                                <label>Contact</label>
                                <input type="text" id="edit-contact-input" class="input" name="contact">
                            </div>
                            <div class="input-form">
                                <label>Address</label>
                                <input type="text" id="edit-address-input" class="input" name="address">
                            </div>
                            <div class="button-form">
                                <a href="#" class="btn-close"> CLOSE </a>
                                <button type="submit" class="btn-submit"> SUBMIT </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END POP UP EDIT -->


                <!-- START TABLE -->
                <div class="outer-wrapper">
                    <div class="table-wrapper">
                        <table>
                            <!-- Header -->
                            <tr>
                                <th>NO</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>CONTACT</th>
                                <th>ADDRESS</th>
                                <th class="change">ACTIONS</th>
                            </tr>

                            <!-- Value -->
                            <?php
                            $counter = 1;
                            foreach ($data as $supplier) { ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td><?= $supplier->getName()?></td>
                                    <td><?= $supplier->getEmail()?></td>
                                    <td><?= $supplier->getContact()?></td>
                                    <td><?= $supplier->getAddress()?></td>
                                    <td>
                                        <div class="button-control">
                                            <a href="#" class="button-edit" data-id="<?=$supplier->getId()?>" data-name="<?= $supplier->getName()?>" data-email="<?= $supplier->getEmail()?>" data-contact="<?= $supplier->getContact()?>" data-address="<?= $supplier->getAddress()?>">EDIT</a>
                                            <a href="../repository/supplier/deleteSupplier.php?id=<?= $supplier->getId() ?>" class="button-delete">DELETE</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $counter++;
                            } ?>
                        </table>
                    </div>
                </div>
                <!-- END TABLE -->
            </div>
            <!-- END CONTENT-->
        </div>


        <!-- JS -->
        <script src="../assets/js/script.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                supplierPopUp();
            });
        </script>
        
    </body>
</html>
