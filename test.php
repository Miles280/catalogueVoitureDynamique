<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_FILES);
    //Etape 1 fichier present
    if (isset($_FILES['image']) and $_FILES['image']['error'] == 0) {
        // Etape 2
        if ($_FILES['image']['size'] <= 1000000) {
            //Etape 3
            $extension = $_FILES['image']['type'];
            $extensions_autorisees = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
            if (in_array($extension, $extensions_autorisees)) {
                //Etape 4
                move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . uniqid() . $_FILES['image']['name']);
                echo "L'envoi a bien été effectué !";
?>
                <img src="images/">
<?php
            } else {
                echo ('J\'accepte que les jpg, jpeg, gif, png');
            }
        } else {
            echo ('le fichier est trop lourd 1MB max');
        }
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <label>Upload Image</label>
    <input type="file" name="image">
    <input type="submit" value="Valider">
</form>