<?php
session_start();

// Only admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites") or die(mysqli_connect_error());

if (!isset($_GET['id'])) {
    echo "Order ID is missing.";
    exit;
}

$order_id = $_GET['id'];

// GET ORDER INFO
$order_query = mysqli_query($con, "SELECT * FROM orders WHERE id='$order_id'") or die(mysqli_error($con));
$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    echo "Order not found.";
    exit;
}

// GET ORDER ITEMS
$items_result = mysqli_query($con, "SELECT * FROM order_items WHERE order_id='$order_id'") or die(mysqli_error($con));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt_#<?php echo $order_id; ?>_EatBites</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 20px;
            color: #333;
            max-width: 400px;
            margin: auto;
        }
        .receipt-container {
            border: 1px dashed #ccc;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #8B0000;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #8B0000;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info p {
            margin: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            border-bottom: 1px solid #333;
            text-align: left;
            padding: 5px 0;
            font-size: 14px;
        }
        td {
            padding: 5px 0;
            font-size: 14px;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            border-top: 2px solid #333;
            padding-top: 10px;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
        @media print {
            body { margin: 0; padding: 0; }
            .receipt-container { border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="header">
            <h1>🍴 EatBites</h1>
            <p>Deliciously Yours</p>
            <p>Tel: +60 123-456789</p>
        </div>

        <div class="info">
            <p><strong>Receipt No:</strong> #<?php echo $order_id; ?></p>
            <p><strong>Table:</strong> <?php echo $order['table_no']; ?></p>
            <p><strong>Date:</strong> <?php echo date('d/m/Y h:i A', strtotime($order['order_time'])); ?></p>
            <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
            <p><strong>Payment:</strong> <?php echo $order['payment_status']; ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $total = 0;
            while ($item = mysqli_fetch_assoc($items_result)) { 
                if ($item['item_status'] != 'canceled') {
                    $total += $item['subtotal'];
                }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['menu_name']); ?></td>
                    <td class="text-right"><?php echo $item['quantity']; ?></td>
                    <td class="text-right">RM <?php echo number_format($item['subtotal'], 2); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <div class="total-section">
            <div style="display: flex; justify-content: space-between;">
                <span>TOTAL AMOUNT</span>
                <span>RM <?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing EatBites!</p>
            <p>Please come again.</p>
            <p><?php echo date('d M Y, h:i A'); ?></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            // Optional: Close window after printing
            // window.onafterprint = function() { window.close(); }
        }
    </script>
</body>
</html>
<?php
mysqli_close($con);
?>
