<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uploaded Images | Test API Images</title>
    <link rel="stylesheet" href="<?= base_url("assets/bulma/css/") ?>bulma.min.css">
    <link rel="stylesheet" href="<?= base_url("assets/own/css/") ?>style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="https://unpkg.com/bulma-modal-fx/dist/css/modal-fx.min.css" />
    <script type="text/javascript" src="https://unpkg.com/bulma-modal-fx/dist/js/modal-fx.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <figure class="navbar-item has-background-white has-text-dark">
                <img src="<?= base_url("assets/logo.png") ?>" alt="Telkom Indonesia">
            </figure>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="<?= base_url("user/") ?>">
                    Beranda
                </a>
                <a class="navbar-item" href="<?= base_url("user/manage") ?>">
                    Kelola User
                </a>
                <a class="navbar-item" href="<?= base_url("user/mitra_manage") ?>">
                    Kelola Mitra
                </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="dropdown">
                        <div class="dropdown-trigger">
                            <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3">
                                <span><?= $this->session->userdata("nama") ?></span>
                                <span class="icon is-small">
                                    <i class="fas fa-sort-down" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                        <div class="dropdown-menu" id="dropdown-menu3" role="menu">
                            <div class="dropdown-content">
                                <a href="<?= base_url("home/destroy") ?>" class="dropdown-item">
                                    LogOut!
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>
    <div class="hero is-fullheight-with-navbar is-primary is-bold">
        <section class="section">
            <div class="container">
                <div class="columns is-desktop">
                    <div class="column">
                        <h1 class="title">
                            Kelola Mitra!
                        </h1>
                        <p class="subtitle">
                            Berikut adalah data mitra...
                        </p>
                    </div>
                    <div class="column userplus">
                        <button class="button is-info" data-target="iomodal" onclick="tambahuser()">+ Tambah Mitra</button>
                    </div>
                </div>
                <div class="box is-white">
                    <div class="table-container">
                        <table id="dataPelanggan" class="table table is-striped table is-hoverable" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dis->db->get("mitra_images")->result() as $d) { ?>
                                    <tr>
                                        <td class=""></td>
                                        <td><?= $d->nama_mitra ?></td>
                                        <td><?= $d->chatid_mitra ?></td>
                                        <td>
                                            <button class="tag is-danger" onclick="deleteUser('<?= $d->id_mitra ?>')"><i class="fas fa-trash px-2"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="iomodal" class="modal modal-fx-fadeInScale">
        <div class="modal-background"></div>
        <div class="modal-content modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Tambah User</p>
                <button class="modal-button-close delete" aria-label="close"></button>
            </header>
            <div class="bg-loading hide">
                <div class="hook">
                    <div class="loader has-text-centered"></div>
                </div>

            </div>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nama Lengkap</label>
                    <div class="control">
                        <input class="input" id="nama" type="text" name="nama">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Username / E-Mail</label>
                    <div class="control">
                        <input class="input" id="unem" type="text" name="unem">
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" id="pw1" type="password" name="pw1">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Re-Type Password</label>
                            <div class="control">
                                <input class="input" id="pw2" type="password" name="pw2">
                            </div>
                        </div>
                    </div>


            </section>
            <footer class="modal-card-foot">
                <button id="submit" class="button is-success">Kirim</button>
                <button class="modal-button-close button">Cancel</button>
            </footer>
        </div>
    </div>
    <script>
        function deleteUser(id_user) {
            Swal.fire({
                title: 'Konfirmasi Hapus User',
                text: "Apakah anda yakin untuk menghapus user?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?= base_url("user/deluser") ?>",
                        type: "post",
                        cache: false,
                        dataType: "json",
                        data: {
                            email: id_user
                        },
                        success: function(data) {
                            if (data.log == "ALL_OK") {
                                Swal.fire({
                                    title: 'Berhasil Menghapus User!',
                                    text: "Jika user saat ini sedang login, maka user tersebut tidak dapat akses pada login berikutnya",
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Refresh!'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Kesalahan!',
                                    text: "Mohon Hubungi Admin!",
                                    icon: 'error',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Refresh!'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        }
        $("#submit").on("click", function() {
            $("#submit").addClass("is-loading");
            $(".bg-loading").removeClass("hide");

            $.ajax({
                url: "<?= base_url("user/register") ?>",
                type: "post",
                cache: false,
                dataType: "json",
                data: {
                    nama: $("#nama").val(),
                    unem: $("#unem").val(),
                    pw1: $("#pw1").val(),
                    pw2: $("#pw2").val(),
                },
                success: function(data) {
                    var data = data;
                    $("#submit").removeClass("is-loading");
                    $(".bg-loading").addClass("hide");
                    if (data.resulted == "ALL_OK") {
                        Swal.fire({
                            title: 'Berhasil Menambahkan User!',
                            text: "Refresh untuk melanjutkan",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Refresh!'
                        }).then((result) => {
                            if (result.value) {
                                window.location.reload();
                            }
                        });
                    } else {
                        if (data.resulted == "pass_no_match") {
                            Swal.fire({
                                title: 'Password tidak cocok!',
                                text: "Mohon masukkan password yang sama!",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                            });
                        } else {
                            Swal.fire({
                                title: 'Username sudah terdaftar!',
                                text: "Mohon masukkan username / email lain!",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                            });
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        // highlight.js
        (function() {
            document.querySelectorAll('pre code').forEach(function(block) {
                hljs.highlightBlock(block);
            });
        })();
    </script>
    <script>
        function tambahuser() {
            $("#iomodal").addClass("is-active");
        }

        $(".modal-button-close").click(function() {
            $(".modal").removeClass("is-active");
        });

        $(document).ready(function() {
            var dropdown = document.querySelector('.dropdown');
            dropdown.addEventListener('click', function(event) {
                event.stopPropagation();
                dropdown.classList.toggle('is-active');
            });
            var t = $('#dataPelanggan').DataTable({

                "language": {
                    "decimal": "",
                    "emptyTable": "<article class='message is-danger'><div class='message-header'><p>Waduh...</p></button></div><div class='message-body'>Belum ada datanya nih...</div></article>",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Menampilkan _MENU_ entri",
                    "loadingRecords": "Memuat Data...",
                    "processing": "Memproses...",
                    "search": "Cari:",
                    "zeroRecords": "Tidak ada hasil yang cocok",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk sorting kolom secara ascending",
                        "sortDescending": ": aktifkan untuk sorting kolom secara descending"
                    }
                },
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }, {
                    "searchable": false,
                    "orderable": false,
                    "targets": 3
                }],
                "order": [
                    [1, 'asc']
                ]
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
        document.addEventListener('DOMContentLoaded', () => {

            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {

                        // Get the target from the "data-target" attribute
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);

                        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');

                    });
                });
            }

        });
    </script>
</body>

</html>