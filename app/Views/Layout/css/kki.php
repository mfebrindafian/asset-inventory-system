<link rel="stylesheet" href="assets/extensions/filepond/filepond.css" />
<link href="<?= base_url('/assets/css/add/select2.min.css') ?>" rel="stylesheet" />
<link href="<?= base_url('/assets/css/add/select2-bootstrap.min.css') ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('/assets/css/datatable.css') ?>">

<style>
    .skeleton-animation {
        display: flex;
        flex-direction: column;
    }

    .skeleton-item {
        width: 100%;
        height: 18px;
        margin: 10px;
        background-color: #d6e2ff;
        /* Light gray background color */
        border-radius: 4px;
        animation: skeleton-pulse 1s infinite;
    }

    @keyframes skeleton-pulse {
        0% {
            opacity: 0.2;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.2;
        }
    }
</style>