// Prezzo base dichiarato nel frontend
let prezzoBase = 100;

// Mostra il prezzo base nel frontend
document.getElementById('prezzo-base-front').innerText = prezzoBase + ' €';

// Funzione che aggiorna il prezzo totale in base alle selezioni
function aggiornaPrezzo() {
    // Recupera i valori selezionati dai vari <select>
    let sedi = parseFloat(document.getElementById('sedi').value);
    let utenti = parseFloat(document.getElementById('utenti').value);
    let movimenti = parseFloat(document.getElementById('movimenti').value);
    let abbonamento = parseFloat(document.getElementById('abbonamento').value);

    // Calcola il prezzo finale sommando il prezzo base e le opzioni selezionate
    let prezzoFinale = prezzoBase + sedi + utenti + movimenti + abbonamento;

    // Aggiorna il contenuto del riepilogo con il prezzo finale
    document.getElementById('riepilogo-prezzo').innerText = `Prezzo totale: ${prezzoFinale} €`;

    // Aggiorna il campo nascosto con il prezzo totale per inviarlo nel form
    document.getElementById('totale').value = prezzoFinale;
}

// Aggiungi un listener per ogni selettore (dropdown) per rilevare i cambiamenti
document.getElementById('sedi').addEventListener('change', aggiornaPrezzo);
document.getElementById('utenti').addEventListener('change', aggiornaPrezzo);
document.getElementById('movimenti').addEventListener('change', aggiornaPrezzo);
document.getElementById('abbonamento').addEventListener('change', aggiornaPrezzo);

// Inizializza il prezzo al caricamento della pagina
aggiornaPrezzo();

// Funzione per chiudere il modal
function closeModal() {
    document.getElementById('resultModal').style.display = 'none';
}

// Aggiungi un listener al pulsante di chiusura del modal
document.querySelector('.close').addEventListener('click', closeModal);

// Chiudi il modal anche cliccando all'esterno di esso
window.addEventListener('click', function(event) {
    const modal = document.getElementById('resultModal');
    if (event.target == modal) {
        closeModal();
    }
});



