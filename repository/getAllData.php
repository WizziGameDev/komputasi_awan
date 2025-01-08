<?php

use Cassandra\Date;

require_once "../model/supplierModel.php";
require_once "../model/itemModel.php";
require_once "../model/purchaseModel.php";
require_once "../model/saleModel.php";
require_once "connection.php";

// Supplier
function getAllSupplier(): array
{
    $connection = getConnection();
    $sql = "SELECT * FROM supplier";
    $result = $connection ->query($sql);

    $array = [];

    while ($row = $result->fetch())
        $array[] = new Supplier(
            id: $row["id"],
            name: $row["name"],
            email: $row["email"],
            contact: $row["contact"],
            address: $row["address"]
        );

    return $array;
}

// Item
function getAllItem(): array
{
    $connection = getConnection();
    $sql = "SELECT * FROM item";
    $result = $connection ->query($sql);

    $array = [];

    while ($row = $result->fetch())
        $array[] = new Item(
            id: $row["id"],
            name: $row["name"],
            price: $row["price"],
            stock: $row["stock"],
            size: $row["size"],
            category: $row["category"]
        );

    return $array;
}

// Transaction Supplier
/**
 * @throws Exception
 */
function getAllPurchase(): array
{
    $connection = getConnection();
    $query = "SELECT 
        p.id AS purchase_id,
        p.tgl_purchase,
        s.name AS supplier_name, -- Mengambil nama supplier
        SUM(dp.quantity) AS quantity,
        SUM(dp.total_price) AS total_price
    FROM 
        purchase p
    JOIN 
        detail_purchase dp ON p.id = dp.purchase_id
    JOIN 
        supplier s ON p.supplier_id = s.id -- Join dengan tabel supplier
    GROUP BY 
        p.id, p.tgl_purchase, s.name";

    $result = $connection->query($query);

    $array = [];

    // Data to Array
    while ($row = $result->fetch()) {
        $tgl_purchase = new DateTime($row['tgl_purchase']);

        $array[] = new Purchase(
            id: $row['purchase_id'],
            tgl_purchase: $tgl_purchase,
            supplier_name: $row['supplier_name'],
            quantity: $row["quantity"],
            total_price: $row['total_price']
        );
    }
    return $array;
}


// Sale Customer
/**
 * @throws Exception
 */
function getAllSale(): array
{
    $connection = getConnection();
    $query = "SELECT 
        s.id AS sale_id,
        s.tgl_sale,
        s.customer_name,
        SUM(ds.quantity) AS quantity,
        SUM(ds.total_price) AS total_price
    FROM 
        sale s
    JOIN 
        detail_sale ds ON s.id = ds.sale_id
    GROUP BY 
        s.id, s.tgl_sale, s.customer_name";

    $result = $connection->query($query);

    $array = [];

    // Data to Array
    while ($row = $result->fetch()) {
        $tgl_sale = new DateTime($row['tgl_sale']);

        $array[] = new Sale(
            id: $row['sale_id'],
            tgl_sale: $tgl_sale,
            customer_name: $row['customer_name'],
            quantity: $row["quantity"],
            total_price: $row['total_price']
        );
    }
    return $array;
}

// DASHBOARD //
function getTotalSales()
{
    $connection = getConnection();
    $sql = "SELECT COUNT(*) AS total_sales FROM sale;";
    $result = $connection->query($sql);

    if ($result) {
        $row = $result->fetch();
        return $row ? $row['total_sales'] : 0;
    } else {
        return false;
    }
}

function getTotalPurchase()
{
    $connection = getConnection();
    $sql = "SELECT COUNT(*) AS total_purchase FROM purchase;";
    $result = $connection->query($sql);

    if ($result) {
        $row = $result->fetch();
        return $row ? $row['total_purchase'] : 0;
    } else {
        return false; // Return false on query error
    }
}

function getTotalCustomer()
{
    $connection = getConnection();
    $sql = "SELECT COUNT(*) AS total_customer FROM sale";
    $result = $connection->query($sql);

    if ($result) {
        $row = $result->fetch();
        return $row ? $row['total_customer'] : 0;
    } else {
        return false; // Return false on query error
    }
}

function getTotalSupplier()
{
    $connection = getConnection();
    $sql = "SELECT COUNT(*) AS total_supplier FROM supplier";
    $result = $connection->query($sql);

    if ($result) {
        $row = $result->fetch();
        return $row ? $row['total_supplier'] : 0;
    } else {
        return false; // Return false on query error
    }
}

// Recent Sale
function getRecentSale():array
{
    $connection = getConnection();
    $sql = "SELECT * FROM sale ORDER BY id DESC LIMIT 4;";
    $result = $connection->query($sql);

    $array = [];

    while ($row = $result->fetch()) {
        $saleData = [
            'id' => $row['id'],
            'tgl_sale' => $row['tgl_sale'],
            'customer_name' => $row['customer_name']
        ];

        // Menambah array asosiatif ke dalam array utama
        $array[] = $saleData;
    }

    return $array;
}

//Recent Purchase
function getRecentPurchase(): array
{
    $connection = getConnection();
    $sql = "SELECT 
                purchase.id, 
                purchase.tgl_purchase, 
                supplier.name AS supplier_name 
            FROM 
                purchase 
            INNER JOIN 
                supplier ON purchase.supplier_id = supplier.id 
            ORDER BY 
                purchase.id DESC 
            LIMIT 4";
                
    $result = $connection->query($sql);
    $array = [];

    while ($row = $result->fetch()) {
        $saleData = [
            'id' => $row['id'],
            'tgl_purchase' => $row['tgl_purchase'],
            'supplier_name' => $row['supplier_name']
        ];

        // Menambah array asosiatif ke dalam array utama
        $array[] = $saleData;
    }

    return $array;
}
