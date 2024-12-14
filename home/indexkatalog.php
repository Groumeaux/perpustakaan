<?php
    function formatIsbnWithHyphens($isbn) {
        return substr($isbn, 0, 3) . '-' . substr($isbn, 3, 3) . '-' . substr($isbn, 6, 4) . '-' . substr($isbn, 10, 2) . '-' . substr($isbn, 12, 1);
    }

	$sql = $koneksi->query("SELECT count(id_buku) as buku from tb_buku");
	while ($data= $sql->fetch_assoc()) {
	
		$buku=$data['buku'];
	}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row" style="display: flex; align-items: center;">
        <div class="col-sm-6">
            <h1 class="m-0">Katalog Buku</h1> 
        </div>
        <div class="col-sm-6 text-right">
            <form class="form-inline" style="margin: 0;" id="searchForm">
                <div class="form-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search" >
                </div>
                <button type="button" id="searchButton" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row" id="searchResults">
            <?php
                $sql = $koneksi->query("SELECT * from tb_buku");
                while ($data= $sql->fetch_assoc()) {
                    $isbn = formatIsbnWithHyphens($data['isbn']);
                    if ($data['cover'] == "" || $data['cover'] == NULL){
                        $cover = "https://placehold.co/200x440";
                    } else {
                        $cover = "images/covers/".$data['cover'];
                    }
                    if ($data['jml_buku'] > 0){
                        $available = '<div class="availability-banner" style="background-color: #1a285d;">Available</div>';
                        $disablecard = '';
                        $jumlahbuku = $data['jml_buku'];
                    } else {
                        $available = '<div class="availability-banner" style="background-color: red;">Unavailable</div>';
                        $disablecard = 'card-disabled';
                        $jumlahbuku = "Unavailable";
                    }
            ?>
            <div class="col-md-3 col-sm-6">
                <div class="panel panel-default <?php echo $disablecard ?>" style="position: relative;">
                    <?php echo $available; ?>
                    <!-- Toggle Button -->
                    <button class="btn btn-circle toggle-btn" onclick="toggleOverlay(this)" style="position: absolute; top: 10px; right: 10px; z-index: 30;">
                        <span class="toggle-icon">&#9776;</span> <!-- Hamburger icon -->
                    </button>

                    <!-- Book Cover -->
                    <div class="panel-heading">
                        <img src="<?= $cover ?>" alt="<?= $data['cover']; ?>" class="img-responsive cover-img" style="object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
                        <!-- Title and Author with Gradient -->
                        <div class="book-info-overlay">
                            <h4><strong><?php echo $data['judul_buku'];  ?></strong></h4>
                            <p><?php echo $data['pengarang'];  ?> (<?php echo $data['th_terbit'];  ?>)</p>
                        </div>
                    </div>

                    <!-- Overlay (Hidden by Default) -->
                    <div class="book-overlay" style="display: none; overflow : auto;">
                        <div class="overlay-content">
                            <h4><strong><?php echo $data['judul_buku'];  ?></strong></h4>
                            <p>Oleh: <strong><?php echo $data['pengarang'];  ?></strong> (Tahun: <strong><?php echo $data['th_terbit'];  ?></strong>)</p>
                            <p>Penerbit: <strong><?php echo $data['penerbit'];  ?></strong></p>
                            <p>ISBN: <strong><?php echo $isbn;  ?></strong></p>
                            <p>Buku tersedia:<strong> <?php echo $jumlahbuku; ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
                }
            ?>
        </div>
    </div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var query = this.value.trim(); // Get the query from the search input

    // If the input is empty, show all books (or reset the results to default state)
    if (query === "") {
        loadAllBooks(); // Load all books when search input is empty
        return;
    }

    // Create an AJAX request for search results
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'home/search.php?query=' + encodeURIComponent(query), true); // Pass query as a GET parameter
    xhr.onload = function() {
        if (xhr.status === 200) {
            var resultContainer = document.getElementById('searchResults');
            resultContainer.innerHTML = ''; // Clear previous results

            if (xhr.responseText === "<p>No books found.</p>") {
                resultContainer.innerHTML = xhr.responseText; // Display "No books found"
            } else {
                resultContainer.innerHTML = xhr.responseText; // Display the new results
            }
        } else {
            console.error("Error with AJAX request: " + xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error("Request failed.");
    };
    xhr.send();
});

// Function to load all books when search input is empty
function loadAllBooks() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'home/search.php?query=', true); // Send an empty query to load all books
    xhr.onload = function() {
        if (xhr.status === 200) {
            var resultContainer = document.getElementById('searchResults');
            resultContainer.innerHTML = ''; // Clear previous results

            if (xhr.responseText === "<p>No books found.</p>") {
                resultContainer.innerHTML = xhr.responseText; // Display "No books found" message
            } else {
                resultContainer.innerHTML = xhr.responseText; // Display all books
            }
        } else {
            console.error("Error with AJAX request: " + xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error("Request failed.");
    };
    xhr.send();
}
function toggleOverlay(button) {
    const card = button.closest('.panel');
    const overlay = card.querySelector('.book-overlay');
    const toggleBtn = card.querySelector('.toggle-btn');
    
    // Toggle visibility of the overlay
    overlay.style.display = overlay.style.display === 'flex' ? 'none' : 'flex';
    
    // Toggle button active state
    toggleBtn.classList.toggle('active');
}
</script>