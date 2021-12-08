<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $title_tag ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= $meta_description ?>" name="description" />
    <meta content="<?= $author ?>" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/alphera/alphera_logo_sm.png') ?>">

    <!-- third party css -->
    <link href="<?= base_url('assets/libs/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/libs/datatables/responsive.bootstrap4.css') ?>" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <link href="<?= base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- App css -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/login.css') ?>" rel="stylesheet" type="text/css" />
    
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Summernote css -->
    <link href="<?= base_url('assets/libs/summernote/summernote-bs4.css') ?>" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

    <script type="text/javascript">
        var base_url = "<?= base_url(); ?>";
    </script>

    <script type="text/javascript" src="<?= base_url('assets/javascript/global.js') ?>"></script>

    <!-- Load React. -->
    <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
    <script
    src="https://unpkg.com/react@16/umd/react.development.js"
    crossorigin
    ></script>
    <script
    src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"
    crossorigin
    ></script>

    <!-- Load Onramper's widget. -->
    <script src="https://unpkg.com/@onramper/widget/dist/index.js" crossorigin></script>

</head>