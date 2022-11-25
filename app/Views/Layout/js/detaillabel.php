<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    const options = {
        margin: [2, 0.5, 0.9, 0.5],
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