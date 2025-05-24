<!-- jQuery (PASTIKAN PALING ATAS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap dan Popper -->
<script src="{{ asset('/') }}template/assets/js/core/popper.min.js"></script>
<script src="{{ asset('/') }}template/assets/js/core/bootstrap.min.js"></script>

<!-- Plugin Tambahan -->
<script src="{{ asset('/') }}template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="{{ asset('/') }}template/assets/js/plugin/chart.js/chart.min.js"></script>
<script src="{{ asset('/') }}template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="{{ asset('/') }}template/assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Kaiadmin -->
<script src="{{ asset('/') }}template/assets/js/kaiadmin.min.js"></script>

<!-- Script Kustom -->
<script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
    });

    document.querySelectorAll('.btn-konfirmasi').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + id).submit();
                }
            });
        });
    });
</script>
