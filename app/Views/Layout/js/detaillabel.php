<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/html2pdf.js') ?>"></script>
<script>
    const options = {
        margin: [0.1, 0.1, 3, 2.3],
        filename: 'label_<?= $bmn['kd_barang']; ?>.pdf',
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 2,
            width: 850,
            height: 300
        },
        jsPDF: {
            unit: 'in',
            format: 'a4',
            orientation: 'portrait'
        }
    }

    var objstr = document.getElementById('label');


    var strr = objstr;
    $('#cetak').click(function(e) {
        e.preventDefault();
        var element = document.getElementById('label');
        html2pdf().from(strr).set(options).save();
    });
</script>