<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function getSearchSuggestions(query) {
                $.ajax({
                    url: 'search-suggestions.php',
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        $('#searchSuggestions').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            $('input.search-form_txt').on('input', function() {
                var searchQuery = $(this).val();
                if (searchQuery.length >= 3) {
                    getSearchSuggestions(searchQuery);
                } else {
                    $('#searchSuggestions').empty();
                }
            });
        });
    </script>
    <style>
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product {
            width: 100%;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .product img {
            max-width: 100px;
        }

        .product-info {
            flex: 1;
            margin-left: 20px;
        }

        .product-name {
            font-weight: bold;
            font-size: 18px;
        }

        .product-description {
            margin-top: 5px;
            font-size: 14px;
        }

        .product-price {
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
        }
        div#searchResults {
            width: 780;
            margin-top: 70px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div id="searchResults" class="product-container">
            <?php
            $mysqli = require './database.php';

            $searchQuery = $_GET['query'];

            $sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<a href='product.php?id=" . $row['id'] . "'>";
                    echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "' />";
                    echo "<div class='product-info'>";
                    echo "<h3 class='product-name'>" . $row['name'] . "</h3>";
                    echo "</a>";
                    echo "<p class='product-description'>" . $row['description'] . "</p>";
                    echo "<p class='product-price'>" . number_format(floatval(rtrim(rtrim($row['price'], '0'), '.'))) . "원</p><hr>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No results found.";
            }

            $mysqli->close();
            ?>
        </div>

        <div id="searchSuggestions"></div>
    </main>
</body>
</html>
