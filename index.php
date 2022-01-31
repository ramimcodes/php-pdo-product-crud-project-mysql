<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM products ORDER BY created_date DESC');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


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
        <h1>PRODUCT CRUD</h1>
        <section class="mt-3">
            <div>
                <a href="created_new_product.php">
                    <button type="button" class="btn btn-sm btn-primary fw-bold">
                        CREATE NEW PRODUCT
                    </button>
                </a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">IMAGE</th>
                        <th scope="col">NAME</th>
                        <th scope="col">PRICE</th>
                        <th scope="col">CREATED</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $item) : ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1; ?></th>
                            <td>
                                <img style="width: 50px;" class="img-fluid" src="<?php echo $item['image']; ?>" alt="">
                            </td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['created_date']; ?></td>
                            <td>
                                <a href="update.php?id=<?php echo $item['id']; ?>" type="button" class="btn btn-sm btn-primary">Edit</a>
                                <form method="post" action="delete.php" style="display: inline-block;">
                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="id" class="form-check-input" value="<?php echo $item['id']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-sm ">Delete</button>
                                </form>
                                <a href="view.php?id=<?php echo $item['id']; ?>" type="button" class="btn btn-sm btn-success">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

</body>

</html>