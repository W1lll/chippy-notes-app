<!-- /views/contact-us.php by Hussein--> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Chippy Notes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

    <!-- Header Section -->
     <!-- header will go here -->
    <!-- end of header section -->
  
    <!-- Main Content -->
    <main>
        <section>
            <h2>Contact Details</h2>
            <p>Email: info@chippynotes.com</p>
            <p>Phone: +1234567890</p>
        </section>

        <section>
            <h2>Leave a Message</h2>
            <form action="#" method="post">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <div>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </section>
    </main>

    <!-- Footer Section (Included using PHP) -->
    <?php include '../footer.php'; ?>

</body>
</html>
