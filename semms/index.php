<HTML ng-app="semms">
    <head>
        <meta name="robots" content="noindex">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-route.min.js"></script>
        <script type="text/ng-template" src="admin/admin-page.php"></script>
        <script>
            window.location.href = "#!admin";
        </script>
    </head>
    <body>
        <div ng-view></div>
        <H1 style="text-align: center">Welcome, This is the index page!!</H1>
        <script src="js\app.js"></script>
        <script src="js\admin.js"></script>
    </body>
</HTML>