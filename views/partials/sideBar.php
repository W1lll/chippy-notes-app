<!-- partials/sideBar.php -->
<div class="nav">
    <header>Notes</header>
    <nav>
        <?php foreach ($notes as $note): ?>
            <button class="note-link" data-note-id="<?php echo htmlspecialchars($note['NoteID']); ?>">
                <?php echo htmlspecialchars($note['Title']); ?>
            </button>
        <?php endforeach; ?>
    </nav>
</div>
