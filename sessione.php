// All'inizio di ogni pagina protetta
session_start();

if (!isset($_SESSION['user_id'])) {
    // Se l'utente non è loggato, reindirizzalo alla pagina di login
    header('Location: login.php');
    exit();
}
