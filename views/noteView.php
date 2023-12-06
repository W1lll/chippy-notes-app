<!-- Views/noteView.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Note Display</title>
</head>
<body>
    <form action="index.php" method="POST">
        <input type="text" name="inputText" id="inputText">
        <input type="submit" style="display: none;">
    </form>

    <?php if (isset($displayText)): ?>
        <p>Entered Text: <?php echo htmlspecialchars($displayText); ?></p>
    <?php endif; ?>

    <script>
        document.getElementById('inputText').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
</body>
</html>
