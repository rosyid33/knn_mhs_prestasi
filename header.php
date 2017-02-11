<header class="primary">
    <div class="container">
        <div class="brand">
            <a href="index.php">
                <div class="text">
                    K-NN
                </div>
            </a>
            <h2>
                SISTEM PENCARIAN MAHASISWA
                <br>BERPRESTASI DAN BERMASALAH
                <br> AKADEMIK
            </h2>
        </div>
        <div class="right social trp">
            <?php
            if(isset($_SESSION['knn_mhs_prestasi_username'])){
                echo $_SESSION['knn_mhs_prestasi_username']." | ".$_SESSION['knn_mhs_prestasi_level_name'];
            }
            ?>
        </div>
    </div>
</header>