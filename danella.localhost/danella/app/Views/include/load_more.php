<script>
	const alertDiv = document.getElementById("alertDiv");
	const dataDiv = document.getElementById("dataDiv");
	const loadMoreDiv = document.getElementById("loadMoreDiv");

	var ajaxURL = "<?= base_url($baseUrl); ?>";
	var page = 1;

	if (isLoadMore()) {
		var loadMore = `<div class="mt-4 d-flex justify-content-center">
							<button class="btn rounded-0 px-4 fs-5 primary-btn text-center" id="loadMoreButton">Load More</button>
						</div>`;
		loadMoreDiv.innerHTML += loadMore;

		const loadMoreButton = document.getElementById("loadMoreButton");
		loadMoreButton.addEventListener("click", () => {
			loadMoreButton.disabled = true;
			loadMoreButton.innerHTML = '<i class="bx bx-loader bx-spin"></i> Load More';
			page++;
			// Delay for loader effect to be seen
			setTimeout(() => {
				initLoadMore(page);
				loadMoreButton.innerHTML = 'Load More';
				loadMoreButton.disabled = false;
			}, 200);
		});
	}

	function initLoadMore(page) {
		$.ajax({
			url: ajaxURL + page,
			type: "GET",
			dataType: "html",
			success: function (data) {
				dataDiv.innerHTML += data;
			}
		}).done(function (data) {
			if (!isLoadMore()) {
				loadMoreDiv.classList.remove("d-flex");
				loadMoreDiv.style.display = 'none';
			}
		}).fail(function (jqXHR, ajaxOptions, thrownError) {
			var alert = `<?= view_cell('\Cells\AlertCell::ajaxFailAlert'); ?>`;
			alertDiv.innerHTML += alert;
		});
	}


	function isLoadMore() {
		var nextQueryCount = page + 1;
		var pageCountArray = <?= json_encode($arrayPageCount); ?>;
		return pageCountArray.includes(nextQueryCount);
	}

</script>