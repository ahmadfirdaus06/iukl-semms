<div class="container-fluid p-3" ng-init="get()" style="background-color: inherit" ng-app="semms">
    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-pills">
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/dashboard"><h4 class="my-auto text-white">My Dasboard</h4></a>
                </li>
                <li class="nav-item my-auto">
                    <a class="nav-link"><h4 class="my-auto text-white"><span><i class="fas fa-chevron-right"></i></span></h4></a>
                </li>     
                <li class="nav-item my-auto">
                    <a class="nav-link" href="#!/main/counselor/cases"><h4 class="my-auto text-white"><u>Cases</u></h4></a>
                </li>                                         
            </ul>   
        </div>
    </div>
    <div class="container-fluid bg-white card p-0 mt-3">
        <div class="card-body p-0">
            <div class="card-header bg-primary text-white">
                <h5 class="my-auto">Hearing</h5>
            </div>
            <div style="overflow: auto" class="card-body p-0">
                <table id="userTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="notification in notifications" title="Click for more details">
                            <td>{{$index+1}}</td>
                            <td>{{notification.subject}}</td>
                            <td>{{notification.description}}</td>
                            <td>{{notification.date_created}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>