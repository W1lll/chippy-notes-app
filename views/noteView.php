<!-- Views/noteView.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Note Display</title>
    <meta charset="UTF-8">
    <meta name="description" content="Simple note jotting app.">
    <meta name="author" content="Group 14">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>
    <div class="content-wrapper">

        <div>
            <h1 id="noteTitleHeading"></h1>
            <div id='note-message'></div>
        </div>

        <!-- Form to add/update a note -->
        <form class="text-bar" id="create-update-note">
            <input type="text" name="noteInputText" id="noteInputText" placeholder="Enter note content" data-test-id="new-note-input">
            <input type="hidden" name="noteId" id="noteId"> <!-- Hidden input for note ID if updating -->
            <input type="hidden" name="noteTitle" id="noteTitle"> <!-- Hidden input for note ID if updating -->
            <button type="submit" data-test-id="submit-note">
                <span class="material-symbols-outlined">arrow_upward_alt</span>
            </button>
        </form>

        <script>
            document.getElementById('create-update-note').addEventListener('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                fetch('index.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('noteInputText').value = '';
                        document.getElementById('note-message').innerHTML = data.note.Content;
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            document.getElementById("noteInputText").addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault(); // Prevent default form submission on Enter key
                    this.form.dispatchEvent(new Event('submit')); // Manually trigger form submit
                }
            });

            function handleKeyPress(e) {
                var noteInputText = document.getElementById("noteInputText");
                var activeElement = document.activeElement;

                if (!activeElement || activeElement.tagName !== 'INPUT' || activeElement.type !== 'text') {
                    if (document.activeElement !== noteInputText) {
                        noteInputText.focus();
                        e.preventDefault();

                        if (e.key.length === 1) {
                            noteInputText.value += e.key;
                        }
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.note-link').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        var noteId = parseInt(this.getAttribute('data-note-id'));

                        // AJAX request to get note content
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'getNoteContent.php?noteId=' + noteId, true);
                        xhr.onload = function() {
                            if (this.status === 200) {
                                document.querySelector('#note-message').innerHTML = JSON.parse(this.responseText).Content;
                                document.querySelector('#noteId').value = noteId;
                                document.querySelector('#noteTitleHeading').innerHTML = JSON.parse(this.responseText).Title;
                                document.querySelector('#noteTitle').value = JSON.parse(this.responseText).Title;
                            } else {
                                console.error('Error fetching note content');
                            }
                        };
                        xhr.send();
                    });
                });
            });

            document.addEventListener("keypress", handleKeyPress);

            document.addEventListener('DOMContentLoaded', function() {
                // Toggle dropdown
                document.querySelectorAll('.options-button').forEach(button => {
                    button.addEventListener('click', function() {
                        // Find the closest note-item parent
                        var noteItem = this.closest('.note-item');
                        // Find the dropdown-content within this note-item
                        var dropdown = noteItem.querySelector('.dropdown-content');
                        dropdown.classList.toggle('show');
                    });
                });


                // Rename note
                document.querySelectorAll('.rename-note').forEach(button => {
                    button.addEventListener('click', function() {
                        var noteItem = this.closest('.note-item');
                        var noteInput = noteItem.querySelector('.note-title');
                        noteInput.removeAttribute('readonly');
                        noteInput.classList.toggle('editable');
                        noteInput.focus();

                        // Save on Enter key press
                        noteInput.addEventListener('keypress', function(e) {
                            if (e.key === "Enter") {
                                noteInput.setAttribute('readonly', true);
                                var noteItem = this.closest('.note-item');
                                var dropdown = noteItem.querySelector('.dropdown-content');
                                dropdown.classList.toggle('show');
                                var noteId = noteInput.getAttribute('data-note-id');
                                var newTitle = noteInput.value;
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', 'updateNote.php', true);
                                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                xhr.onload = function() {
                                    // Reload the page after getting response from the server
                                    if (xhr.status === 200) {
                                        window.location.reload();
                                    } else {
                                        console.error("Error updating note. Server responded with status:", xhr.status);
                                    }
                                };
                                xhr.send('noteId=' + noteId + '&title=' + encodeURIComponent(newTitle));
                            }
                        });

                    });
                });

                // Delete note
                document.querySelectorAll('.delete-note').forEach(button => {
                    button.addEventListener('click', function() {
                        var noteId = this.closest('.note-item').querySelector('.note-title').getAttribute('data-note-id');
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'deleteNote.php', true);
                        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            // Reload the page after getting response from the server
                            if (xhr.status === 200) {
                                window.location.reload();
                            } else {
                                console.error("Error deleting note. Server responded with status:", xhr.status);
                            }
                        };
                        xhr.send('noteId=' + noteId);
                        setTimeout(function () {window.location.reload()}, 500);
                    });
                });
            });
        </script>
    </div>
</body>

</html>