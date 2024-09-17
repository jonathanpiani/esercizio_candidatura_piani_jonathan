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

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuratore di Prodotto e Acquisto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Configuratore di Prodotto</h1>

    <!-- Sezione del configuratore: Prezzo base e opzioni -->
    <div class="configuratore">
        <div class="row">
            <label class="col">Prezzo base del prodotto:</label>
            <div class="col prezzo-col">
                <span id="prezzo-base-front">100 €</span>
            </div>
        </div>
        <div class="row">
            <label for="sedi" class="col">Numero di sedi dell'azienda:</label>
            <select id="sedi" name="sedi" aria-label="Numero di sedi dell'azienda">
                <option value="0">Seleziona il numero di sedi</option>
                <?php echo $opzioni_sedi; ?>
            </select>
        </div>
        <div class="row">
            <label for="utenti" class="col">Numero di utenti:</label>
            <select id="utenti" name="utenti" aria-label="Numero di utenti">
                <option value="0">Seleziona il numero di utenti</option>
                <?php echo $opzioni_utenti; ?>
            </select>
        </div>
        <div class="row">
            <label for="movimenti" class="col">Numero di movimenti annui:</label>
            <select id="movimenti" name="movimenti" aria-label="Numero di movimenti annui">
                <option value="0">Seleziona i movimenti annui</option>
                <?php echo $opzioni_movimenti; ?>
            </select>
        </div>
        <div class="row">
            <label for="abbonamento" class="col">Tipo di abbonamento:</label>
            <select id="abbonamento" name="abbonamento" aria-label="Tipo di abbonamento">
                <option value="0">Seleziona il tipo di abbonamento</option>
                <?php echo $opzioni_abbonamento; ?>
            </select>
        </div>
    </div>

    <!-- Riquadro riepilogo del prezzo -->
    <div id="riepilogo">
        <h2>Riepilogo</h2>
        <p id="riepilogo-prezzo">Prezzo totale: 0 €</p>
    </div>

    <section class="bodyform">
        <!-- Form per la raccolta dei dati di acquisto -->
        <h2>Form di Acquisto</h2>
        <form id="formAcquisto" method="POST" action="">
            <div class="form-container">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="Nome" required>
            </div>
            <div class="form-container">
                <label for="cognome">Cognome:</label>
                <input type="text" name="cognome" id="cognome" placeholder="Cognome" required>
            </div>
            <div class="form-container">
                <label for="indirizzo">Indirizzo:</label>
                <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo" required>
            </div>
            <div class="form-container">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="form-container">
                <label for="codice_fiscale">Codice Fiscale:</label>
                <input type="text" name="codice_fiscale" id="codice_fiscale" placeholder="Codice Fiscale" required>
            </div>
            <div class="form-container">
                <label for="partita_iva">Partita IVA:</label>
                <input type="text" name="partita_iva" id="partita_iva" placeholder="Partita IVA" required>
            </div>

            <!-- Campo nascosto per il totale del prezzo -->
            <input type="hidden" name="totale" id="totale">

            <button type="submit">Acquista</button>
        </form>

        <!-- Modal -->
        <div id="resultModal" class="modal" class="<?php echo !empty($message) ? 'active' : ''; ?>">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p id="modalMessage"><?php echo addslashes($message); ?></p>
            </div>
        </div>
    </section>

    <script>
    function openModal(message) {
        document.getElementById('modalMessage').innerText = message; // Imposta il messaggio
        document.getElementById('resultModal').style.display = 'block'; // Mostra il modal
    }

    document.addEventListener("DOMContentLoaded", function() {
    <?php if (!empty($message)): ?>
        openModal(<?php echo json_encode($message); ?>);
    <?php endif; ?>
});
    </script>
    <script src="script.js"></script>
</body>
</html>