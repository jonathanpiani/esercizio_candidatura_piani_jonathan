<?php
// Include il file di configurazione del database
    include 'database_configuratore/configuratore_db.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuratore di Prodotto e Acquisto</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<body>
    <header>
        <h1>Configura il Tuo Prodotto</h1>
    </header>

    <main> 
        <h2>Personalizza il Tuo Prodotto</h2> 
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
            <h2>Dettagli per il Tuo Acquisto</h2>
            <form id="formAcquisto" method="POST">
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

                <button type="submit">Acquista Ora</button>
            </form>

        <!-- Modal -->
        <div id="resultModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="modalMessage"></div>
            </div>
        </div>

        <?php 
        // Resetta il messaggio dopo averlo mostrato
        if (!empty($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
        ?>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
