<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
    </style>
    <script>
        function toggleSubMenu() {
            const listItem = event.target.parentElement;
            listItem.classList.toggle('active');
        }

        function hideSubMenu() {
            const listItem = event.target.parentElement;
            listItem.classList.remove('active');
        }
    </script>
</head>
<?php include 'admin-sidebar.php'; ?>
</html>
