<style>
.lineaire-simple {
  background-color: #4158D0;
  background-image: linear-gradient(69deg, #4158D0 10%, #a0389a 60%, #fc70ff 100%);
  color: white;
  font-family: "Gill Sans", sans-serif;
}
a {
  color: white;
}
</style>

<body class="lineaire-simple">
<a href="https://192.168.204.141/wordpress">
   BACK TO EXERCISES
</a>
<?php
$premiereValeur = 16469;
$deuxiemeValeur = 1735;

$result = $premiereValeur * $deuxiemeValeur;

// traitement fichier contenant le code
$file = $_FILES['codefile']['tmp_name'];

$output = shell_exec('python3 '.$file.' '.$premiereValeur.' '.$deuxiemeValeur);

$num_exo = $_POST['num_exo'];
// Database Credential
$servername = "192.168.204.144";
$username = "wp_user";
$password = "wp_password";
$dbname = "wordpress_db";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($result == $output) {
    // Check connection
    if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
    }
    // Vérifiez si il existe déjà une note
    $sql = 'SELECT * FROM wp_notes WHERE id_user = 2 AND num_exo = "'.$num_exo.'"';
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
            $sql = "UPDATE wp_notes SET resultat = 20 WHERE id_user=2 AND num_exo = ".$num_exo;
            if ($conn->query($sql) === TRUE) {
                    echo("Félicitations ! Vous avez de nouveau réussi cet exercice.");
            } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
            }
    } else {
            $sql = "INSERT INTO wp_notes (id_user, num_exo, resultat) VALUES (2, ".$num_exo.", 20)";
            if ($conn->query($sql) === TRUE) {
                    echo("Félicitations ! Vous avez réussi cet exercice.");
            } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    $conn->close();
} else {
    // Check connection
    if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
    }
    // Vérifiez si il existe déjà une note
    $sql20 = 'SELECT * FROM wp_notes WHERE id_user = 2 AND num_exo = "'.$num_exo.'" AND resultat = 20';
    $result20 = $conn->query($sql20);

    $sql0 = 'SELECT * FROM wp_notes WHERE id_user = 2 AND num_exo = "'.$num_exo.'" AND resultat = 0';
    $result0 = $conn->query($sql0);

    if ($result20->num_rows > 0){
             echo "Vous avez déjà eu l'entièreté des points pour cet exercice. Cependant votre code n'est pas fonctionnel";
    } else if ($result0->num_rows > 0) {
             echo "Dommage Votre code n'est toujours pas fonctionnel.";
    } else {
        $sql = "INSERT INTO wp_notes (id_user, num_exo, resultat) VALUES (2, ".$num_exo.", 0)";

        if ($conn->query($sql) === TRUE) {
                echo("Dommage ! L'exercice que vous avez soumis n'est pas correct.");
        } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
}
?>
</body>