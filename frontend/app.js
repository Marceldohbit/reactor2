// Where the PHP backend lives (C:\xampp\htdocs\backend)
const API_URL = 'http://localhost/backend';

// Show a success or error message in the <p id="message"> element
function showMessage(text, isError) {
    const p = document.getElementById('message');
    p.textContent = text;
    p.style.color = isError ? 'darkred' : 'darkgreen';
}
