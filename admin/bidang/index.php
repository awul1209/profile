
    <main>
    
             <!-- Tambahkan ini di dalam container-fluid -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4" style="max-width: 1100px; margin: auto;">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Master Data Bidang</h6>
                                </div>
                                <div class="card-body">

                                    <!-- Tab Button -->
                                <!-- <div class="mb-3">
                                <?php $query_bidang=mysqli_query($config,"SELECT nama_bidang FROM bidang");
                                while($row_bidang=mysqli_fetch_array($query_bidang)){
                                ?>
                                <a href="?page=<?= $row_bidang['nama_bidang'] ?>" class="btn btn-light btn-sm"><?= $row_bidang['nama_bidang'] ?></a>
                                <?php } ?>
                                </div> -->


                                    <!-- Form Input -->
                                    <div class="container-fluid px-4">
    <div class="card mb-4" style="max-width: 1100px; margin: auto;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalGalerifoto">Tambah Bidang</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead">
                        <tr>
                            <th>No</th>
                            <th>Bidang</th>
                            <th>Browsur</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getalldata = mysqli_query($config, 'SELECT * FROM bidang');
                        
                        $i = 1;
                        while ($data = mysqli_fetch_array($getalldata)) {
                            $id_bidang=$data['id'];
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $data['nama_bidang'] ?></td>
                                <td><img src="./img/bidang/<?= $data['gambar'] ?>" class="zoomable" width="150px"></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $id_bidang ?>">Edit</button>
                            <a class="btn btn-danger btn-sm" href="?page=del-bidang&kode=<?php echo $id_bidang; ?>&photo=<?= $data['gambar']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="mt-1">Hapus
                                </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit<?= $id_bidang ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Galeri Foto</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_bidang" value="<?= $data['id'] ?>">
                                            <div class="modal-body">
<p class="fs-5 fw-semibold">Bidang</p>
<input type="text" name="bidang" placeholder="Masukkan Foto" class="form-control" required value="<?= $data['nama_bidang'] ?>">
<p class="fs-5 fw-semibold">Gambar</p>
<input class="form-control" type="file" name="file" >
<input type="hidden" name="gambarLama" value="<?= $data['gambar'] ?>">
<br>
<?php if ($data['gambar']) : ?>
<img class="foto-preview-tambah1" src="./img/bidang/<?= $data['gambar'] ?>" 
alt="Gambar 1" width="80">
<?php else : ?>
<p>No image</p>
<?php endif; ?>
<br>
<br>
                                                <button type="submit" class="btn btn-primary" name="updateBidang">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

                <!-- End Page Content -->
            </div>
            <!-- End Main Content -->
        </div>
        
        <!-- End Content Wrapper -->
    </div>
    
    <!-- End Page Wrapper -->
    

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Tambah Modal -->
    <div class="modal fade" id="modalGalerifoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bidang</h5>
                    <button class="btn-close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p class="fs-5 fw-semibold">Bidang</p>
                        <input type="text" name="bidang" placeholder="Masukkan Foto" class="form-control" required>
                        <p class="fs-5 fw-semibold">Gambar</p>
                        <input type="file" name="file" placeholder="Masukkan Foto" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="simpanBidang">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['simpanBidang'])){
    $bidang=$_POST['bidang'];

     $gambar = ($_FILES['file']['error'] === 4) ? NULL : upload();

    // Query untuk insert data ke tabel
    $query = "INSERT bidang (nama_bidang, gambar) 
              VALUES ('$bidang', '$gambar')";

    $simpan = mysqli_query($config, $query);
    if ($simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=bidang';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=bidang';
            }
        })</script>";
    }
}

// update bidang
if(isset($_POST['updateBidang'])){
    $id_bidang=$_POST['id_bidang'];
    $bidang = $_POST['bidang'];
    $gambarLama = $_POST['gambarLama'];

    // Menangani gambar
    // $gambar1 = ($_FILES['gambar']['error'] === 4) ? NULL : upload1();
    $gambar = ($_FILES['file']['error'] === 4) ? $gambarLama: upload();

    $update=mysqli_query($config, "UPDATE bidang set 
    nama_bidang='$bidang',
    gambar='$gambar'
    where id='$id_bidang';
    ");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Update Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=bidang';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Update Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='?page=bidang';
            }
        })</script>";
    }
}

function upload()
{
    $namafile = $_FILES['file']['name'];
    $ukuranfile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpname = $_FILES['file']['tmp_name'];

    // cek gambar tidak diupload
    if ($error === 4) {
        echo "
        <script>
        alert('pilih gambar');
        </script>
        
        ";
        return false;
    }
    // cek yang di uplod gambar atau tidak
    $ektensigambarvalid = ['jpg', 'jpeg', 'png', 'webp','jfif'];

    $ektensigambar = explode('.', $namafile);
    $ektensigambar = strtolower(end($ektensigambar));
    // cek adakah string didalam array
    if (!in_array($ektensigambar, $ektensigambarvalid)) {
        echo "
        <script>
        alert('yang anda upload bukan gambar');
        </script>
        ";

        return false;
    }
    // cek jika ukuran terlalu besar
    if ($ukuranfile > 90000000) {
        echo "
        <script>
        alert('ukuran gambar terlalu besar');
        </script>
        
        ";
        return false;
    }

    // lolos pengecekan , gambar siap di upload
    // generete nama gambar baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ektensigambar;

    move_uploaded_file($tmpname, './img/bidang/' . $namafilebaru);

    return $namafilebaru;
}
?>


