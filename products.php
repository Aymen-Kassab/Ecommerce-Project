<?php 
include("db_connect.php");
include("header.php");
session_start();

class product {
    public $Pname;
    public $price;
    public $stock;
    public $category;

    function __construct($Pname, $category, $price, $stock){
        $this->Pname = $Pname;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }

    function get_Pname(){
       return $this->Pname; }
    function get_price(){ 
      return $this->price; }
    function get_stock(){
      return $this->stock; }
    function get_category(){ 
        return $this->category; }
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($link, $delete)) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . mysqli_error($link);
    }
}

$edit_mode = false;
$edit_product = null;

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($link, "SELECT * FROM products WHERE id = $id");
    if ($result && mysqli_num_rows($result) > 0) {
        $edit_product = mysqli_fetch_assoc($result);
        $edit_mode = true;
    }
}

if (isset($_POST['add'])) {
    $product = new product($_POST["Pname"], $_POST["category"], $_POST["price"], $_POST["stock"]);

    $file_name = basename($_FILES['Pimg']['name']);
    $tempname = $_FILES['Pimg']['tmp_name'];
    $folder = 'uploads/' . $file_name;

    if (move_uploaded_file($tempname, $folder)) {
        $add_product = "INSERT INTO products(productName, category,  price, stock, image)
                        VALUES('{$product->Pname}', '{$product->category}', '{$product->price}', '{$product->stock}', '$file_name')";

        if (mysqli_query($link, $add_product)) {
            echo "Product added successfully with image!";
        } else {
            echo "Product insert failed: " . mysqli_error($link);
        }
    } else {
        echo "Image upload failed!";
    }
}


if (isset($_POST['update']) && isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $Pname = $_POST["Pname"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];

    if (!empty($_FILES['Pimg']['name'])) {
        $file_name = basename($_FILES['Pimg']['name']);
        $tempname = $_FILES['Pimg']['tmp_name'];
        $folder = 'uploads/' . $file_name;
        move_uploaded_file($tempname, $folder);
        $img_sql = ", image = '$file_name'";
    } else {
        $img_sql = "";
    }

    $update = "UPDATE products SET productName='$Pname', category = '$category' , price='$price', stock='$stock'  $img_sql WHERE id='$id' ";

    if (mysqli_query($link, $update)) {
        echo "Product updated successfully!";
    } else {
        echo "Update failed: " . mysqli_error($link);
    }
}
?>

<section id="header3">
    <h1 id="title">Products</h1>
    <p>manager</p>
</section>
<br>
<section>  <?php if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($link, $_GET['search']);
    $products = mysqli_query($link, "SELECT * FROM products WHERE productName LIKE '%$search%'");
} else {
    $products = mysqli_query($link, "SELECT * FROM products");
}
 ?>
       <div class="searchContainer">
    <form method="GET" action="products.php" id="searchForm">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>
<div id="productSection">

  <!-- Add Product Form -->
  <div id="add_products">
    <div class="addP">
      <form method="post" enctype="multipart/form-data" action="products.php<?php echo $edit_mode ? '?edit=' . $edit_product['id'] : ''; ?>">
        <h1><?php echo $edit_mode ? 'EDIT PRODUCT' : 'ADD PRODUCT'; ?></h1><br>

        <label for="Pname">Name:</label>
        <input type="text" id="Pname" name="Pname" value="<?php echo $edit_mode ? htmlspecialchars($edit_product['productName']) : ''; ?>" required><br><br>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
          <option value="">Select a category</option>
          <option value="Action" <?php if($edit_mode && $edit_product['category'] == 'Action') echo 'Action'; ?>>Action</option>
          <option value="Adventure" <?php if($edit_mode && $edit_product['category'] == 'Adventure') echo 'Adventure'; ?>>Adventure</option>
          <option value="RPG" <?php if($edit_mode && $edit_product['category'] == 'RPG') echo 'RPG'; ?>>RPG</option>
          <option value="Horror" <?php if($edit_mode && $edit_product['category'] == 'Horror') echo 'Horror'; ?>>Horror</option>
          <option value="Fantasy" <?php if($edit_mode && $edit_product['category'] == 'Fantasy') echo 'Fantasy'; ?>>Fantasy</option>
          <option value="Fighting" <?php if($edit_mode && $edit_product['category'] == 'Fighting') echo 'Fighting'; ?>>Fighting</option>
        </select><br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $edit_mode ? htmlspecialchars($edit_product['price']) : ''; ?>" required><br><br>

        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock" value="<?php echo $edit_mode ? htmlspecialchars($edit_product['stock']) : ''; ?>" required><br><br>
        <label>Image:</label>
        <label for="fileUpload" class="custom-file-label"><span id="fileName">No file selected</span>
        </label>  
        <input id="fileUpload" class="hidden-file-input" type="file" name="Pimg"><br><br>

        <?php if ($edit_mode): ?>
          <input id="update_btn" type="submit" value="Update" name="update"/><br><br>
        <?php else: ?>
          <input id="add_btn" type="submit" value="Add new product" name="add"/><br><br>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Products List (Moved Outside!) -->
  <div class="alter_products">
    <?php while ($row = mysqli_fetch_assoc($products)) { ?>
      <div class="product">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['productName']); ?>" />
        <h2><?php echo htmlspecialchars($row['productName']); ?></h2>
        <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
        <p>Stock: <?php echo htmlspecialchars($row['stock']); ?></p>
        <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
        <button class="edit_btn"><a href="products.php?edit=<?php echo $row['id']; ?>">Edit</a> </button> 
        <button class="delete_btn"><a href="products.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a></button> 
      </div>
    <?php } ?>
  </div>

</div>

</section>

<script src="script_admin/script.js"></script>
</body>
</html>
