<nav class="menu">
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            if (empty($_SESSION['knn_mhs_prestasi_id'])) {
                ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <?php
            }
            else {
                ?>
                <li class="magz-dropdown">
                    <a href="#">Masters <i class="ion-ios-arrow-right"></i></a>
                    <ul>
                        <li><a href="index.php?menu=mahasiswa">Mahasiswa</a></li>
                        <li><a href="index.php?menu=dosen">Dosen</a></li>
                        <li><a href="index.php?menu=mata_kuliah">Mata Kuliah</a></li>
                        <li><a href="index.php?menu=periode">Periode</a></li>
                        <li class="magz-dropdown"><a href="index.php?menu=">Troubleshoot <i class="ion-ios-arrow-right"></i></a>
                            <ul>
                                <li><a href="index.php?menu=">Software</a></li>
                                <li class="magz-dropdown"><a href="index.php?menu=">Hardware <i class="ion-ios-arrow-right"></i></a>
                                    <ul>
                                        <li><a href="index.php?menu=">Child Menu 1</a></li>
                                        <li><a href="index.php?menu=">Child Menu 2</a></li>
                                        <li><a href="index.php?menu=">Child Menu 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="index.php?menu=">Menu 3</a>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li><a href="index.php?menu=input_nilai">Input Nilai</a></li>
                <li><a href="index.php?menu=proses">Proses</a></li>
                <li><a href="index.php?menu=hasil">Hasil</a></li>
                <?php
            }
            ?>

            <li><a href="index.php?menu=tentang">Tentang</a></li>
            <?php
            if (isset($_SESSION['knn_mhs_prestasi_id'])) {
                ?>
                <li><a href="logout.php">Logout</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>