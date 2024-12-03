<?php
	$sql = $koneksi->query("SELECT count(id_buku) as buku from tb_buku");
	while ($data= $sql->fetch_assoc()) {
	
		$buku=$data['buku'];
	}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row" style="display: flex; align-items: center;">
        <div class="col-sm-6">
            <h1 class="m-0">Book Catalogue</h1> 
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
            ?>
            <div class="col-md-3 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 0; height: 280px; overflow: hidden;">
                        <img src="https://placehold.co/1000x800" alt="Book Cover 1" class="img-responsive" style="width: 100%; height: 100%;">
                    </div>
                    <div class="panel-body">
                        <h4>Book Name: <strong><?php echo $data['judul_buku'];  ?></strong></h4>
                        <p>Author: <strong><?php echo $data['pengarang'];  ?></strong> (Published: <strong><?php echo $data['th_terbit'];  ?></strong>)</p>
                        <p>Publisher: <strong><?php echo $data['penerbit'];  ?></strong></strong></p>
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
</script>