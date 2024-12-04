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
                $cover = "https://placehold.co/200x440";
            } else {
                $cover = "images/covers/".$row['cover'];
            }

            echo '<div class="col-md-3 col-sm-6"><br>
                    <div class="panel panel-default" style="position: relative;"><br>
                        <button class="btn btn-circle toggle-btn" onclick="toggleOverlay(this)" style="position: absolute; top: 10px; right: 10px; z-index: 30;"><br>
                            <span class="toggle-icon">&#9776;</span><br>
                        </button><br>

                        <div class="panel-heading"><br>
                            <img style="padding: 0; height: 280px; overflow: hidden;"><img src="' . htmlspecialchars($cover, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['cover'], ENT_QUOTES, 'UTF-8') . '" class="img-responsive cover-img" style="object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;"><br>
                            <div class="book-info-overlay"><br>
                                <h4><strong>' . htmlspecialchars($row['judul_buku'], ENT_QUOTES, 'UTF-8') . '</strong></h4><br>
                                <p>' . htmlspecialchars($row['pengarang'], ENT_QUOTES, 'UTF-8') . ' (' . htmlspecialchars($row['th_terbit'], ENT_QUOTES, 'UTF-8') . ')</p><br>
                            </div><br>
                        </div><br>

                        <div class="book-overlay" style="display: none; overflow : auto;"><br>
                            <div class="overlay-content"><br>
                                <h4>' . htmlspecialchars($row['judul_buku'], ENT_QUOTES, 'UTF-8') . '</strong></h4><br>
                                <p>Oleh: <strong>' . htmlspecialchars($row['pengarang'], ENT_QUOTES, 'UTF-8') . '</strong> (Tahun: <strong>' . htmlspecialchars($row['th_terbit'], ENT_QUOTES, 'UTF-8') . '</strong>)</p><br>
                                <p>Penerbit: <strong>' . htmlspecialchars($row['penerbit'], ENT_QUOTES, 'UTF-8') . '</strong></p><br>
                                <p>ISBN: <strong>' . htmlspecialchars($isbn, ENT_QUOTES, 'UTF-8') . '</strong></p><br>
                                <button class="btn btn-success">Reserve</button><br>
                            </div><br>
                        </div><br>
                    </div><br>
                </div><br>';
        }
    } else {
        echo "<p>Buku tidak ditemukan!</p>";
    }
}
?>