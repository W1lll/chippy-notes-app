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
        <form action="index.php" method="POST" class="text-bar">
            <input type="text" name="noteInputText" id="noteInputText" placeholder="Enter note content">
            <input type="hidden" name="noteId" id="noteId"> <!-- Hidden input for note ID if updating -->
            <input type="hidden" name="noteTitle" id="noteTitle"> <!-- Hidden input for note ID if updating -->
            <button type="submit">
                <span class="material-symbols-outlined">arrow_upward_alt</span>
            </button>
        </form>

        <script>
            document.getElementById("noteInputText").addEventListener("keypress", function (e) {
                if (e.key === "Enter") {
                    this.form.submit();
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

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.note-link').forEach(item => {
                    item.addEventListener('click', function (e) {
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
        </script>
    </div>
</body>
</html>