// Takes the user back to the previous page.

document.getElementById('goBack').addEventListener('click', function(event) {
event.preventDefault();
window.history.back();
});
