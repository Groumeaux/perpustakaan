<?php
	$sql = $koneksi->query("SELECT count(id_buku) as buku from tb_buku");
	while ($data= $sql->fetch_assoc()) {
		$buku=$data['buku'];
	}
    if (isset($_GET['msg']) == "reservasisukses"){
        echo "<script> alert('Reservasi Berhasil!')</script>";
    }
    function formatIsbnWithHyphens($isbn) {
        return substr($isbn, 0, 3) . '-' . substr($isbn, 3, 3) . '-' . substr($isbn, 6, 4) . '-' . substr($isbn, 10, 2) . '-' . substr($isbn, 12, 1);
    }
?>

<!-- Content Header (Page header) & Search Bar-->
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
                $no = 1;
                $sql = $koneksi->query("SELECT * from tb_buku");
                while ($data= $sql->fetch_assoc()) {
                    $isbn = formatIsbnWithHyphens($data['isbn']);
                    if ($data['cover'] == "" || $data['cover'] == NULL){
                        $cover = "https://placehold.co/1000x800";
                    } else {
                        $cover = "images/covers/".$data['cover'];
                    }
            ?>
            <!-- Book Card -->
            <div class="col-md-3 col-sm-6">
                <div class="panel panel-default" style="position: relative;">
                    <button class="btn btn-success" style="position: absolute; top: 5px; right: 5px; z-index: 10;" onclick="confirmAction('<?php echo $data['id_buku'] ?>')">Reservasi</button>
                    <div class="panel-heading" style="padding: 0; height: 280px; overflow: hidden;">
                        <img src="<?= $cover ?>" alt="<?= $data['cover']; ?>" class="img-responsive" style="object-fit: scale-down;width: 100%; height: 100%;">
                    </div>
                    <div class="panel-body">
                        <h4><strong><?php echo $data['judul_buku'];  ?></strong></h4>
                        <p>Oleh: <strong><?php echo $data['pengarang'];  ?></strong> (Tahun: <strong><?php echo $data['th_terbit'];  ?></strong>)</p>
                        <p>Penerbit: <strong><?php echo $data['penerbit'];  ?></strong></strong></p>
                        <p>ISBN: <strong><?php echo $isbn;  ?></strong></strong></p>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

<script>
    function confirmAction(idbuku) {
        var confirmation = confirm("Apakah anda yakin ingin mereservasi buku " + idbuku + "?");
        if (confirmation) {
            window.location.href = "pengguna/reservasi/add_reservasi.php?book=" + encodeURIComponent(idbuku);
        } else {
            alert("Reservasi dibatalkan.");
        }
    }
    document.getElementById('searchInput').addEventListener('input', function() {
        var query = this.value.trim(); // Get the query from the search input

        // If the input is empty, show all books (or reset the results to default state)
        if (query === "") {
            loadAllBooks(); // Load all books when search input is empty
            return;
        }

        // Create an AJAX request for search results
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'pengguna/search.php?query=' + encodeURIComponent(query), true); // Pass query as a GET parameter
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
        xhr.open('GET', 'pengguna/search.php?query=', true); // Send an empty query to load all books
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