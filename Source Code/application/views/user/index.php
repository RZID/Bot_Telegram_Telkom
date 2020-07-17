<!DOCTYPE html>
<html class="has-navbar-fixed-top">

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
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>

<body>
	<nav class="navbar has-shadow is-fixed-top" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<figure class="navbar-item has-background-white has-text-dark" href="#">
				<img src="<?= base_url("assets/logo.png") ?>">
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
			</div>

			<div class="navbar-end">
				<div class="navbar-item">
					<div style="height:100%;width:0.5px;background-color:grey;" class="mx-2"></div>
					Halo, <?= $this->session->userdata("nama") ?>
					<div style="height:100%;width:0.5px;background-color:grey;" class="mx-2"></div>
					<button onclick="location.replace('<?= base_url('home/destroy') ?>')" class="button is-danger"><i class="fas fa-sign-out-alt"></i></button>
				</div>
			</div>
		</div>
	</nav>
	<div class="hero is-fullheight-with-navbar ">
		<section class="section">
			<div class="container">
				<h1 class="title">
					Cari ID Pelanggan!
				</h1>
				<p class="subtitle">
					Berikut adalah datanya...
				</p>
				<div class="box is-white">
					<div class="table-container">
						<table id="dataPelanggan" class="table table is-striped table is-hoverable" style="width:100%;">
							<thead>
								<tr>
									<th>No.</th>
									<th>ID. Pelanggan</th>
									<th>Jumlah Foto</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($dis->db->get("pelanggan_images")->result() as $d) { ?>
									<tr>
										<td class=""></td>
										<td><?= $d->id_pelanggan ?></td>
										<td><?php
											$get_count_image = $dis->db->where_in("mediagr_id", $dis->md_additional->count($d->id_pelanggan))->get("tbphoto_images")->num_rows();
											echo $get_count_image;
											?></td>
										<td>
											<?php if ($dis->db->where_in("mediagr_id", $dis->md_additional->count($d->id_pelanggan))->get("tbphoto_images")->num_rows() > 0) { ?>
												<button class="tag is-success" onclick="window.location.replace('<?= base_url('user/pelanggan?id_pelanggan=') . $d->id_pelanggan ?>');"><i class="fas fa-eye px-2"></i></button>
											<?php } ?>

											<button class="tag is-danger" onclick="deleteEvidence('<?= $d->id_pelanggan ?>')"><i class="fas fa-trash px-2"></i></button>
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
	<script>
		function deleteEvidence(idpelanggan) {
			Swal.fire({
				title: 'Yakin menghapus evidence?',
				text: "Evidence yang dihapus tidak dapat dikembalikan beserta foto yang sudah diupload pada evidence ini!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya! Hapus saja'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: "<?= base_url("user/deleteevidence") ?>",
						data: {
							idpelanggan: idpelanggan
						},
						dataType: "json",
						cache: false,
						success: function(data) {
							if (data.result == "OK") {
								Swal.fire({
									title: 'Sukses Menghapus Evidence!',
									text: 'Me-refresh halaman!',
									type: 'success',
									showConfirmButton: false,

								});
								window.location.reload(true);
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Galat menghapus foto!',
									text: 'Mohon hubungi admin...',
								})
							}
						}
					});
				}
			});
		}
		$(document).ready(function() {

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