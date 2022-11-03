<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
<script type="text/javascript" src="<?= base_url('/assets/js/html2canvas.min.js') ?>"></script>
<script>
    function downloadPDFWithjsPDF() {
        var doc = new jspdf.jsPDF('p', 'pt', 'a4');

        doc.html(document.querySelector('#label'), {
            callback: function(doc) {

                doc.save('label-<?= $bmn['kd_barang']; ?>.pdf');
            },
            margin: [20, 20, 20, 20],
            x: 1,
            y: 200,
        });
    }
    document.querySelector('#cetak').addEventListener('click', downloadPDFWithjsPDF);
</script>