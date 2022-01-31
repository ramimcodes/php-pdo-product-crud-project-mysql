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
$name = $product['name'];
$description = $product['description'];
$price = $product['price'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    if (!$name) {
        $errors[] = 'Product Name Is Required';
    }
    if (!$price) {
        $errors[] = 'Product Price Is Required';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagepath = $product['image'];
        if ($image && $image['tmp_name']) {
            if ($product['image']) {
                unlink($product['image']);
            }

            $imagepath = 'images/' . randonString(8) . '/' . $image['name'];
            mkdir(dirname($imagepath));
            move_uploaded_file($image['tmp_name'], $imagepath);
        }

        $result = $pdo->prepare('UPDATE products SET name = :name, description = :description, image = :image, price = :price WHERE id = :id');

        $result->bindValue(':name', $name);
        $result->bindValue(':description', $description);
        $result->bindValue(':image',  $imagepath);
        $result->bindValue(':price', $price);
        $result->bindValue(':id', $id);
        $result->execute();
        header('Location:index.php');
    }
}


function randonString($n)
{
    $character = '123456789abcdefghijklmnopqrstwvxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($character) - 1);
        $str .= $character[$index];
    }

    return $str;
}
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
        <h1>UPDATE PRODUCT <strong> <?php echo $product['name']; ?></strong> </h1>
        <section class="my-5">
            <div class="mb-3">
                <a href="index.php" class="btn fw-bold btn-primary">Go Back To Products</a>
            </div>
            <?php if (!empty($errors)) : ?>
                <div class="mb-3 alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <?php if ($product['image']) : ?>
                    <div>
                        <img class="w-25" src="<?php echo $product['image']; ?>" alt="">
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <br>
                    <input name="image" type="file" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input name="name" value="<?php echo $name; ?>" type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo $description; ?>
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Price</label>
                    <input name="price" type="number" value="<?php echo $price; ?>" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </section>
    </main>

</body>

</html>