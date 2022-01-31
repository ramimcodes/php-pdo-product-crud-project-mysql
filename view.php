<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location:index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id ');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PRODUCT CRUD</title>
</head>

<body>
    <main class="container px-5 pt-5">
        <div class="overflow-hidden">
            <div class="row gx-5">
                <div class="col-1">
                    <div class="p-3"></div>
                </div>
                <div class="col-10">
                    <div class="p-3 border bg-light d-flex ">
                        <div>
                            <img style="width: 250px;" src="<?php echo $product['image']; ?>" alt="">
                        </div>
                        <div class="ms-3">
                            <h2><?php echo $product['name']; ?></h2>
                            <h5>Price : $ <?php echo $product['price']; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-1">
                    <div class="p-3"></div>
                </div>
            </div>
        </div>

    </main>

</body>

</html>