<?php
session_start();
include_once(__DIR__ . '/../../dbconnect.php');

// Lấy thông tin giỏ hàng
$cart = [];
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
}

// Lấy thông tin user từ database
$user = null;
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql = "SELECT username, address FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Checkout - Demo Shop</title>

    <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>

    <link href="/shop/assets/frontend/css/style.css"
        type="text/css" rel="stylesheet" />

    <style>
        .image {
            width: 80px;
            height: 80px;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    <main role="main" class="mb-2">
        <div class="container mt-4">
            <h1 class="text-center">Checkout</h1>

            <?php if (empty($cart)) : ?>
                <h2>Your cart is empty.</h2>
                <a href="/shop/frontend" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Continue Shopping</a>
            <?php else : ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $grandTotal = 0;
                        foreach ($cart as $item) :
                            $subtotal = $item['quantity'] * $item['price'];
                            $grandTotal += $subtotal;
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?php if (empty($item['image'])) : ?>
                                        <img src="/shop/assets/shared/img/default-image_600.png" class="img-fluid image" />
                                    <?php else : ?>
                                        <img src="/shop/assets/<?= $item['image'] ?>" class="img-fluid image" />
                                    <?php endif; ?>
                                </td>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['price'], 3, ".", ",") ?> vnđ</td>
                                <td><?= number_format($subtotal, 3, ".", ",") ?> vnđ</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total</strong></td>
                            <td><strong><?= number_format($grandTotal, 3, ".", ",") ?> vnđ</strong></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Billing Information</h3>
                <form action="/shop/frontend/API/placeOrder.php" method="POST">
                    <div class="form-group">
                        <label for="username">Full Name:</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : '' ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address" name="address" readonly><?= isset($user['address']) ? htmlspecialchars($user['address']) : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="note">Note (Optional):</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Place Order</button>
                    <a href="/shop/frontend" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Continue Shopping</a>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
</body>

</html>
