<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uploadDir = 'upload/public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'gif', 'png', 'webp'];
    $maxFileSize = 1000000;

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Gif ou Png ou Webp !';
    }

    if (file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1 Mo !";
    }

    if (empty($errors) && $_FILES['image']['error'] == 0) {
        $_FILES['image']['name'] = uniqid('', true) . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
        echo "Votre fichier a bien été upload";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <?php foreach ($errors as $error) : ?>
            <tr>
                <td><?php echo $error; ?></td>
            </tr>
        <?php endforeach; ?>
 
    </table>
    <form method="post" action="form.php" enctype="multipart/form-data">
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="image" id="imageUpload" />
        <button name="send">Send</button>
    </form>
</body>

</html>
