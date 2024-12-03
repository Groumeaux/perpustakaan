<?php
// Include the database connection
include('../inc/koneksi.php');

function formatIsbnWithHyphens($isbn) {
    return substr($isbn, 0, 3) . '-' . substr($isbn, 3, 3) . '-' . substr($isbn, 6, 4) . '-' . substr($isbn, 10, 2) . '-' . substr($isbn, 12, 1);
}

// Check if it's an AJAX request
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Split the query into individual search terms by spaces
    $searchTerms = explode(" ", $query); 

    // Build the SQL query dynamically
    $sql = "SELECT judul_buku, pengarang, penerbit, th_terbit, isbn, cover FROM tb_buku WHERE";
    
    // For each search term, add a condition to the WHERE clause
    $conditions = [];
    foreach ($searchTerms as $term) {
        $conditions[] = "(
            judul_buku LIKE ? 
            OR pengarang LIKE ? 
            OR penerbit LIKE ? 
            OR th_terbit LIKE ?
            OR REPLACE(isbn, '-', '') LIKE ?
            )";
    }
   
    // Combine the conditions with 'OR'
    $sql .= " " . implode(" AND ", $conditions);

    // Prepare and execute the SQL statement
    $stmt = $koneksi->prepare($sql);
    
    // Bind the parameters dynamically
    $bindParams = [];
    foreach ($searchTerms as $term) {
        $bindParams[] = "%" . $term . "%";
        $bindParams[] = "%" . $term . "%";
        $bindParams[] = "%" . $term . "%";
        $bindParams[] = "%" . $term . "%";
        $bindParams[] = "%" . $term . "%";
    }
    
    $stmt->bind_param(str_repeat('s', count($bindParams)), ...$bindParams);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output the search results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isbn = formatIsbnWithHyphens($row['isbn']);
            if ($row['cover'] == "" || $row['cover'] == NULL){
                $cover = "https://placehold.co/1000x800";
            } else {
                $cover = "images/covers/".$row['cover'];
            }
            echo '<div class="col-md-3 col-sm-6">';
                echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading" style="padding: 0; height: 280px; overflow: hidden;"><img src="' . htmlspecialchars($cover, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['cover'], ENT_QUOTES, 'UTF-8') . '" class="img-responsive" style="object-fit: scale-down; width: 100%; height: 100%;"></div>';
                        echo '<div class="panel-body">';
                            echo '<h4><strong>' . htmlspecialchars($row['judul_buku'], ENT_QUOTES, 'UTF-8') . '</strong></h4>';
                            echo '<p>Oleh: <strong>' . htmlspecialchars($row['pengarang'], ENT_QUOTES, 'UTF-8') . '</strong> (Tahun: <strong>' . htmlspecialchars($row['th_terbit'], ENT_QUOTES, 'UTF-8') . '</strong>)</p>';
                            echo '<p>Penerbit: <strong>' . htmlspecialchars($row['penerbit'], ENT_QUOTES, 'UTF-8') . '</strong></strong></p>';
                            echo '<p>ISBN: <strong>' . htmlspecialchars($isbn, ENT_QUOTES, 'UTF-8') . '</strong></strong></p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Buku tidak ditemukan!</p>";
    }
}
?>
