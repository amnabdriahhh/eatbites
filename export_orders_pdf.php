<?php
session_start();

// Only admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "eatbites") or die(mysqli_connect_error());

// Get all orders
$orders = mysqli_query($con, "SELECT * FROM orders ORDER BY order_time DESC") or die(mysqli_error($con));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orders Report - EatBites</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #8B0000;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #8B0000;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #8B0000;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-preparing {
            background-color: #17a2b8;
            color: #fff;
        }
        .badge-completed {
            background-color: #28a745;
            color: #fff;
        }
        .badge-canceled {
            background-color: #dc3545;
            color: #fff;
        }
        .badge-paid {
            background-color: #28a745;
            color: #fff;
        }
        .badge-unpaid {
            background-color: #dc3545;
            color: #fff;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛎️ EatBites - Orders Report</h1>
        <p>Generated on: <?php echo date('F d, Y h:i A'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Table No</th>
                <th>Total Price</th>
                <th>Order Time</th>
                <th>Order Status</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total_revenue = 0;
        $order_count = 0;
        while ($order = mysqli_fetch_assoc($orders)) { 
            $order_count++;
            if ($order['order_status'] == 'completed') {
                $total_revenue += $order['total_price'];
            }
            
            // Determine status badge class
            $status_class = 'badge-pending';
            if ($order['order_status'] == 'preparing') $status_class = 'badge-preparing';
            elseif ($order['order_status'] == 'completed') $status_class = 'badge-completed';
            elseif ($order['order_status'] == 'canceled') $status_class = 'badge-canceled';
            
            $payment_class = $order['payment_status'] == 'Paid' ? 'badge-paid' : 'badge-unpaid';
        ?>
            <tr>
                <td><strong>#<?php echo $order['id']; ?></strong></td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($order['table_no']); ?></td>
                <td>RM <?php echo number_format($order['total_price'], 2); ?></td>
                <td><?php echo date('d M Y, h:i A', strtotime($order['order_time'])); ?></td>
                <td>
                    <span class="badge <?php echo $status_class; ?>">
                        <?php echo ucfirst($order['order_status']); ?>
                    </span>
                </td>
                <td>
                    <span class="badge <?php echo $payment_class; ?>">
                        <?php echo $order['payment_status']; ?>
                    </span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Total Orders:</strong> <?php echo $order_count; ?> | 
           <strong>Total Revenue (Completed Orders):</strong> RM <?php echo number_format($total_revenue, 2); ?></p>
        <p>&copy; <?php echo date('Y'); ?> EatBites. All rights reserved.</p>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
<?php
mysqli_close($con);
?>
