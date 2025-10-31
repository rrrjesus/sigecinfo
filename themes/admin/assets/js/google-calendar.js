
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= url("/painel/eventos/google-calendar") ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            // The controller will redirect to the Google authentication URL
            window.location.href = this.responseText;
        }
    };
    xhr.send('title=' + encodeURIComponent(title) + '&description=' + encodeURIComponent(description));
