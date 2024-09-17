<?php
session_start(); // Inizializza la sessione

// Connessione al database
$conn = new mysqli("localhost", "root", "", "configuratore");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per ottenere opzioni in base alla categoria
function getOptions($conn, $categoria) {
    $options = '';
    $sql = "SELECT * FROM opzioni_configuratore WHERE categoria='$categoria'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['prezzo'] <= 0) {
                $options .= "<option value='{$row['prezzo']}'>{$row['descrizione']}</option>";
            } else {
                $options .= "<option value='{$row['prezzo']}'>{$row['descrizione']} - {$row['prezzo']} €</option>";
            }
        }
    }
    return $options;
}

// Recupera le opzioni per ogni categoria
$opzioni_sedi = getOptions($conn, 'sedi');
$opzioni_utenti = getOptions($conn, 'utenti');
$opzioni_movimenti = getOptions($conn, 'movimenti');
$opzioni_abbonamento = getOptions($conn, 'abbonamento');

// Inizializza la variabile del messaggio
$message = '';

// Se il form viene inviato, salva i dati nel database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati inviati dal form
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $indirizzo = $_POST['indirizzo'];
    $email = $_POST['email'];
    $codice_fiscale = $_POST['codice_fiscale'];
    $partita_iva = $_POST['partita_iva'];
    $totale = $_POST['totale'];

    // Prepara la query SQL per inserire i dati
    $sql = "INSERT INTO acquisti (nome, cognome, indirizzo, email, codice_fiscale, partita_iva, totale)
            VALUES ('$nome', '$cognome', '$indirizzo', '$email', '$codice_fiscale', '$partita_iva', '$totale')";

    // Esegui la query e controlla il risultato
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Acquisto completato con successo.\n"; // Imposta il messaggio nella sessione
        
        // Invia l'email di conferma
        $to = $email;
        $subject = "Conferma di Acquisto";
        $body = "Ciao $nome $cognome,\n\nIl tuo acquisto è stato completato con successo.\n\nDettagli dell'acquisto:\nNome: $nome\nCognome: $cognome\nIndirizzo: $indirizzo\nEmail: $email\nCodice Fiscale: $codice_fiscale\nPartita IVA: $partita_iva\nTotale: $totale €\n\nGrazie per aver scelto il nostro servizio!";
        $headers = "From: noreply@tuosito.com"; // Sostituisci con il tuo indirizzo email

        // Controlla se l'email è stata inviata correttamente
        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['message'] .= " Email di conferma inviata a $email.";
        } else {
            $_SESSION['message'] .= " Si è verificato un errore nell'invio dell'email di conferma.";
        }
        
    } else {
        $_SESSION['message'] = "Errore: " . $conn->error; // Imposta il messaggio di errore nella sessione
    }

    // Chiude la connessione
    $conn->close();

    // Reindirizza per evitare il re-invio del form
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Controlla se esiste un messaggio nella sessione
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Resetta il messaggio dopo averlo mostrato
}
?>
