<HTML ng-app="semms">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- included library -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-route.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.22/angular-ui-router.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>
    <body style="height:100%">
    <div ui-view></div>
    <!-- custom angularjs script -->
    <script src="js\app.js"></script>
    <script src="js\admin.js"></script>
    <script src="js\user.js"></script>
    <script src="js\bursary.js"></script>
    <script src="js\counselor.js"></script>
    </body>
</HTML>