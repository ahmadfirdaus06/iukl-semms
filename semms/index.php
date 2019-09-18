<HTML ng-app="semms">
    <head>
        <title>IUKL SEMMS</title>
        <link rel="icon" type="image/png" href="/semms.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- included library -->
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"> -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-route.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.22/angular-ui-router.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <link rel="stylesheet" href="css/css/all.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })();</script> -->
    </head>
    <body style="height:100%; width:100%; min-height:100%; min-width:50%">
    <div ui-view></div>
    <!-- custom angularjs script -->
    <script src="js\app.js"></script>
    <script src="js\admin.js"></script>
    <script src="js\user.js"></script>
    <script src="js\bursary.js"></script>
    <script src="js\counselor.js"></script>
    <script src="js\ui-bootstrap-tpls-2.5.0.min.js"></script>
    </body>
</HTML>