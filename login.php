<?php
session_start();
include('db.php');  // File per la connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prendi i dati dal form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepara la query per cercare l'utente nel database
    $query = "SELECT * FROM utenti WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se l'utente esiste
    if ($result->num_rows > 0) {
        // Se l'utente esiste, recupera i dati
        $user = $result->fetch_assoc();
        
        // Verifica la password (assumendo che sia stata hashata con password_hash)
        if (password_verify($password, $user['password'])) {
            // Autenticazione riuscita
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Redirect alla pagina protetta, ad esempio il dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            // Password errata
            $error = "La password inserita non è corretta.";
        }
    } else {
        // Utente non trovato
        $error = "L'email inserita non corrisponde a nessun account.";
    }
}
?>

<!-- Mostra errore se c'è -->
<?php if (isset($error)): ?>
    <p class="text-red-500 text-center"><?php echo $error; ?></p>
<?php endif; ?>
