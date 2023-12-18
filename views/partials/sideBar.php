<!-- partials/sideBar.php -->
<div class="nav">
    <header>Notes</header>
    <nav>
        <?php foreach ($notes as $note) : ?>
            <div class="note-item">
                <div class="note-visible-wrapper">
                    <input type="text" class="note-title note-link" data-note-id="<?php echo htmlspecialchars($note['NoteID']); ?>" value="<?php echo htmlspecialchars($note['Title']); ?>" readonly>
                    <button class="options-button">&#8942;</button>
                </div>
                <div class="note-options">
                    <div class="dropdown-content">
                        <button class="rename-note">Rename</button>
                        <button class="delete-note">Delete</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>
</div>