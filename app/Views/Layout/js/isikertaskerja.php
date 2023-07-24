<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/jquery.validate.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
    });
</script>

<script>
    console.log(
        $('input[name="keberadaan-barang"]').val()
    )

    let keberadaan = document.getElementsByName("keberadaan-barang")

    $(document).on('change', 'input[name="keberadaan-barang"]', function() {
        checkKategori(this.value)
    })
    $(document).ready(function() {
        console.log(keberadaan[0].value)
        checkKategori(keberadaan[0].value)
    })

    function checkKategori(val) {
        if (val == 'BTD') {
            $('#kategori_btd').removeClass('d-none')
            $('#kategori_bb').addClass('d-none')
        } else if (val == 'BR') {
            $('#kategori_btd').addClass('d-none')
            $('#kategori_bb').removeClass('d-none')
        } else {
            $('#kategori_btd').addClass('d-none')
            $('#kategori_bb').addClass('d-none')
        }
    }
</script>

<script>
    // Custom validation method for handling the required rule based on the value of keberadaan-barang
    $.validator.addMethod("conditionalRequired", function(value, element, params) {
        var keberadaanBarang = $("input[name='keberadaan-barang']:checked").val();
        var kategoriBr = $("select[name='kategori_br']").val();
        var kategoriBtd = $("select[name='kategori_btd']").val();

        if (keberadaanBarang === "BR") {
            return kategoriBr !== "";
        } else if (keberadaanBarang === "BTD") {
            return kategoriBtd !== "";
        }

        return true;
    }, "This field is required.");

    // Initialize the form validation
    $("#kertas-kerja").validate({
        rules: {
            "kondisi-barang": "required",
            "keberadaan-barang": "required",
            "kategori_br": {
                conditionalRequired: true // Use custom validation method
            },
            "kategori_btd": {
                conditionalRequired: true // Use custom validation method
            }
        },
        messages: {
            "kondisi-barang": "Please select Kondisi Barang.",
            "keberadaan-barang": "Please select Keberadaan Barang.",
            "kategori_br": "Please select Kategori BR.",
            "kategori_btd": "Please select Kategori BTD."
        },
        submitHandler: function(form) {
            // Submit the form if it passes validation
            form.submit();
        }
    });
</script>