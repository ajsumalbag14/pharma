<!--THIS HOLDS THE VIEW - department view test-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD Application</title>
    
</head>

<body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js">
</script>
<div ng-app="MyApp" ng-controller="ctrl">
    <div>
        <form>
            <div>
                Search <input type="text" ng-model="search_keyword" name="search_keyword" />
                <input type="button" value="SEARCH" ng-click="searchData()" />
            </div>
        </form>
    </div>

    <table>
        <tr>
            <td>Department Name</td>
            <td>Description</td>
            <td>Date Created</td>
            <td>Status</td>
        </tr>

        <tr ng-repeat="department in departments">
            <td>{{department.DEPARTMENT_NAME}}</td>
            <td>{{department.DESCRIPTION}}</td>
            <td>{{department.DATE_CREATED}}</td>
            <td>{{department.STATUS}}</td>
            <td><button ng-click="deleteRecord(department.DEPARTMENT_ID);">DELETE</button></td>
            <td><button ng-click="displayDetails(department.DEPARTMENT_ID);">EDIT</button></td>
        </tr>

    </table>

    <!--ADD FORMS-->
    <div>
        <h1>Add Record</h1>

        Department Name<input type="text" ng-model="department_name" name="department_name" />
        Description <input type="text" ng-model="description" name="description" />
        <input type="button" value="submit" ng-click="insertRecord()">
        {{msg}}
    </div>

    <!--EDIT FORMS-->

     <div>
        <h1>Edit Record</h1>
        <input type="hidden" ng-model="department_id_details" name="department_id_details" />
        Department Name<input type="text" ng-model="department_name_details" name="department_name_details" />
        Description <input type="text" ng-model="description_details" name="description_details" />
        <input type="button" value="submit" ng-click="updateRecord()">
        {{msg}}
    </div>


    <script type="text/javascript">
        var app = angular.module("MyApp", []);
        app.controller('ctrl', function($scope, $http){

            //DISPLAY ALL RECORDS
            $scope.displayData = function() {
                $http.post("Controller/DepartmentController.php", 
                {
                    "method" : "display"
                })
                .then(function(response) {
                    $scope.departments = response.data.departments;
                })
            }

            //SEARCH FUNCTION
            $scope.searchData = function() {
                $http.post("Controller/DepartmentController.php", 
                {
                    "method" : "search",
                    "search_keyword" : $scope.search_keyword
                })
                .then(function(response) {
                    $scope.departments = response.data.departments;
                })
            } 

             //DISPLAY DETAILS FUNCTION
            $scope.displayDetails = function(department_id) {

                $http.post("Controller/DepartmentController.php", 
                {
                    "method" : "get_details",
                    "department_id" : department_id
                })
                .then(function(response) {
                    
                    $scope.department_id_details = response.data.departments[0].DEPARTMENT_ID;
                    $scope.department_name_details = response.data.departments[0].DEPARTMENT_NAME;
                    $scope.description_details = response.data.departments[0].DESCRIPTION;
                })
            } 

            //INSERT NEW RECORD
            $scope.insertRecord = function() {
                /*
                $http.post("API/apitest.php", 
                {
                    "departments" : $scope.departments
                    
                })
                .then(function() {
                    //$scope.msg = "Successfully added a record";
                    //$scope.displayData();   
                })
                */
                
                $http.post("Controller/DepartmentController.php", 
                {
                    "method" : "add",
                    "department_name" : $scope.department_name,
                    "description" : $scope.description,
                    "status" : 1
                })
                .then(function() {
                    $scope.msg = "Successfully added a record";
                    $scope.displayData();   
                })
            } 

            //UPDATE A RECORD
            $scope.updateRecord = function() {
                
                $http.post("Controller/DepartmentController.php", 
                {
                    "method" : "edit",
                    "department_id" : $scope.department_id_details,
                    "department_name" : $scope.department_name_details,
                    "description" : $scope.description_details,
                    "status" : 1
                    
                })
                .then(function() {
                    $scope.msg = "Successfully edited a record";
                    $scope.displayData();   
                }) 
            } 

            //DELETE A RECORD
            $scope.deleteRecord = function(department_id) {
                
                $http.post("Controller/DepartmentController.php", 
                {
                    "method" : "delete",
                    "department_id" : department_id
                    
                })
                .then(function() {
                    $scope.msg = "Successfully deleted a record";
                    $scope.displayData();   
                }) 
            } 
            $scope.displayData();
        })
    </script>
    
</div>

<!--
<script src="lib/jquery-3.2.1.min.js"></script>
<script src="lib/angular.min.js"></script>
<script src="lib/app.js.js"></script>

-->


</body>

</html>

