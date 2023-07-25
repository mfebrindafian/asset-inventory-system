<script src="assets/extensions/filepond/filepond.js"></script>
<script src="assets/js/pages/filepond.js"></script>
<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/datatable.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('table').DataTable({
            pageLength: 20,
        })
        $('.dataTables_length').addClass('d-none');
        $('.dataTables_filter').addClass('d-none');
        $('.dataTables_info').addClass('mt-4');
        $('.dataTables_paginate').addClass('mt-4');
    });

    $(document).on('keyup', '#searchbar', function() {
        $('table').DataTable().search($('#searchbar').val()).draw();
    });
</script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
        $('.select-satker2').select2({
            dropdownParent: $('#modal-import'),
            theme: "bootstrap"
        });
    });

    $(document).on('change', '#satker-kki', function() {
        if ($(this).val() != '') {
            $('#btn-submit').attr('disabled', false)
        }
    })
</script>

<script>
    let page = 1;
    const perPage = 5;
    let isLoading = false;
    let satker = $('#pilih-satker').val();
    let listKki = null

    async function loadListKki(page) {
        isLoading = true;
        $('#loadingSpinner').show();
        $('#empty').hide();

        const response = await fetch(`<?= base_url("API-list-kki") ?>?page=${page}&perPage=${perPage}&satker=${satker}`);
        listKki = await response.json();
        if (listKki != null) {
            $.each(listKki, function(index, value) {
                $('#listKki').append(`
            <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="row px-4 py-4">
                                    <div class="col-md-10">
                                        <h4 class="card-title">` + listKki[index].nama_satker + `</h4>
                                        <span class="badge bg-light-primary">Jumlah data: ` + listKki[index].jml_perKdBatch + `</span>
                                        <p class="text-muted mt-4 mb-0">Kode Batch: ` + listKki[index].kd_batch + `</p>
                                </div>
                             <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-center">
                                  <a href="<?= base_url('/detail-kki/') ?>` + '/' + listKki[index].kd_batch + `" class="btn btn-outline-primary">Detail</a>
                            </div>
                      </div>
                 </div>
            </div>`)
            });
            page++;
        } else {
            $(window).off('scroll', onScroll);
        }

        isLoading = false;
        $('#loadingSpinner').hide();
        if ($('#listKki').children().length == 0) {
            $('#empty').show();
        }
    }

    function onScroll() {
        if (!isLoading && $(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            loadListKki(page = page + 1);
        }
    }

    $(document).ready(function() {
        loadListKki(page);
        $(window).on('scroll', onScroll);
    });

    $('#pilih-satker').on('change', function() {
        $('#listKki').empty()
        page = 1
        listKki = null
        satker = $('#pilih-satker').val();
        loadListKki(page);
        $(window).on('scroll', onScroll);
    })
</script>