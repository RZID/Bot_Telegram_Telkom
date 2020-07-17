<style>
	.notification {
		position: fixed !important;
		z-index: 999;
		top: 2%;
		right: 2%;
	}

	/* relevant styles */
	.img__wrap {
		position: relative;
		/* height: 200px;
		width: 257px; */
	}

	.img__description_layer {
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		color: #fff;
		visibility: hidden;
		opacity: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		backdrop-filter: blur(8px);
		/* transition effect. not necessary */
		transition: opacity .2s, visibility .2s;
	}

	.img__wrap:hover .img__description_layer {
		visibility: visible;
		opacity: 1;
	}

	.img__description {
		transition: .2s;
		transform: translateY(1em);
	}

	.img__wrap:hover .img__description {
		transform: translateY(0);
	}
</style>
<!DOCTYPE html>
<html class="has-navbar-fixed-top">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Uploaded Images | Test API Images</title>
	<link rel="stylesheet" href="<?= base_url("assets/bulma/css/") ?>bulma.min.css">
	<link rel="stylesheet" href="<?= base_url("assets/own/css/") ?>style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">


	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

	<link rel="stylesheet" href="https://unpkg.com/bulma-modal-fx/dist/css/modal-fx.min.css" />
	<script type="text/javascript" src="https://unpkg.com/bulma-modal-fx/dist/js/modal-fx.min.js"></script>

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
	<div class="hero is-fullheight-with-navbar">
		<section class="section">
			<div class="container">
				<h1 class="title">
					Pelanggan
				</h1>
				<p class="subtitle">
					Berikut adalah data pelanggan <?= $this->input->get("id_pelanggan") ?>
				</p>
				<div class="box is-white">
					<div class="columns is-desktop">
						<?php
						$no = 1;
						$rowfromimg = $this->db->where_in("mediagr_id", $this->md_additional->count($this->input->get("id_pelanggan")))->get("tbphoto_images")->result();
						$numOfCols = 4;
						$rowCount = 0;
						$bootstrapColWidth = 12 / $numOfCols;
						foreach ($rowfromimg as $r) { ?>
							<div class="column">
								<div class="card">
									<div class="card-image">
										<div class="img__wrap">
											<figure class="img__img image is-2by1" style="background-size:cover;background-repeat:no-repeat;background-position: center center; background-image:url(' <?= base_url("assets/uploaded_photo/") . $r->photo_tbphoto ?>')">
											</figure>
											<div class="img__description_layer ">
												<button onclick="modalimg('<?= $r->photo_tbphoto ?>')" class="img__description button is-primary">Lihat foto</button>
											</div>
										</div>
									</div>
									<div class="card-content">
										<div class="media">
											<div class="media-content" style="overflow-x: hidden;overflow-y: hidden;">
												<small>
													Diupload Oleh : @<?= $r->intcaption_tbphoto ?>
												</small>
												<br>
												<small>
													Diupload pada : <?= date("H:i d-m-Y", $r->uploadtime_tbphoto) ?>
												</small>
												<hr>
												<div class="columns">
													<div class="column">
														<button class="button is-danger is-fullwidth" onclick="deletePhoto('<?= $r->id_tbphoto ?>')">Hapus foto!
														</button>
													</div>
													<div class="column is-3">
														<button onclick="redirect('<?= $r->intcaption_tbphoto ?>')" class=" button is-info is-fullwidth"><i class="fab fa-telegram"></i></button>
														<script>
															function redirect(link) {
																var url = "https://t.me/" + link;
																window.location.replace(url);
															}
														</script>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
							$rowCount++;
							if ($rowCount % $numOfCols == 0) echo '</div><div class="columns is-desktop">';
						}
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="modal modal-fx-fadeInScale" id="iomodal">
		<div class="modal-background"></div>
		<div class="modal-content is-huge is-image">
			<p class="" id="imagesss">
			</p>
		</div>
		<button class="modal-close is-large" aria-label="close"></button>
	</div>
	<script>
		function deletePhoto(idphoto) {
			Swal.fire({
				title: 'Yakin menghapus foto?',
				text: "Foto yang dihapus tidak dapat dikembalikan!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya! Hapus saja'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: "<?= base_url("user/deletephoto") ?>",
						data: {
							idphoto: idphoto
						},
						dataType: "json",
						cache: false,
						success: function(data) {
							if (data.result == "OK") {
								Swal.fire({
									title: 'Sukses Menghapus Foto!',
									text: 'Me-refresh halaman!',
									icon: 'success',
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

		function modalimg(idphoto) {
			$("#imagesss").html('<img src="<?= base_url("assets/uploaded_photo/") ?>' + idphoto + '" alt="">');
			$(".modal").addClass("is-active");
		}
		$("#showModal").click(function() {
			$(".modal").addClass("is-active");
		});

		$(".modal-close").click(function() {
			$(".modal").removeClass("is-active");
		});

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
				}],
				"order": [
					[1, 'asc']
				]
			});
			t.on('click', 'tbody td', function() {

				//get textContent of the TD
				console.log('TD cell textContent : ', this.textContent)

				//get the value of the TD using the API 
				console.log('value by API : ', table.cell({
					row: this.parentNode.rowIndex,
					column: this.cellIndex
				}).data());
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