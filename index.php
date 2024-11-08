<?php
include 'header.php';
include 'connection.php';

// Fetch products
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

// Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_btn'])) {
    $update_id = $_POST['update_id'];
    $name = $_POST['update_name'];
    $des = $_POST['update_des'];
    $unit = $_POST['update_unit'];
    $unitprice = $_POST['update_unitprice'];

    $stmt = $conn->prepare("UPDATE product SET name=?, des=?, unit=?, unitprice=? WHERE id=?");
    $stmt->bind_param("ssdii", $name, $des, $unit, $unitprice, $update_id);
    $stmt->execute();
    header("Location: index.php");
}

// Delete product
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $stmt = $conn->prepare("DELETE FROM product WHERE id=?");
    $stmt->bind_param("i", $remove_id);
    $stmt->execute();
    header("Location: index.php");
}
?>

<div class="container">
    <h5>Stock Status</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <form action="index.php" method="post">
                <tr>
                    <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                    <td><input type="text" name="update_name" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td><input type="text" name="update_des" value="<?= htmlspecialchars($row['des']) ?>"></td>
                    <td><input type="number" name="update_unit" value="<?= $row['unit'] ?>"></td>
                    <td><input type="number" name="update_unitprice" value="<?= $row['unitprice'] ?>"></td>
                    <td>
                        <button type="submit" class="btn btn-primary" name="update_btn">Update</button>
                        <a href="index.php?remove=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            </form>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
