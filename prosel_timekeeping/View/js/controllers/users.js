function usersCtrl($scope, $http, sessionService, $location, $stateParams) {
    //check for authentication
    if(!sessionService.get("userID")) //not authenticated
    {
        $location.path('/login');
    }

    $scope.displayUsers = function() {

        //check if the logged in user is admin
        //if admin, display all records
        //else if dsm - display all that is assigned per dsm only

        var userType = sessionService.get("userType");
        var userID = sessionService.get("userID");
        var options = "";

        if(userType== "Administrator")
        {
            options = {
                method: "display"
            }
        }
        else if (userType == "DSM")
        {
            options = {
                method: "displayUserPerDSM",
                userID: userID
            }
        }

        $http.post("../Controller/UsersController.php", options)
        .then(function(response) {
            $scope.users = response.data;
        })
    }

    $scope.displayDetails = function(userID) {

        $stateParams.userID = userID;

        //redirect to user details
        $location.path('index/usersDetails').search($stateParams);
        
    }

    $scope.addRecord = function() {
        //redirect to user add page
        $location.path('index/usersAdd');
    }

    $scope.editRecord = function(userID) 
    {
        $stateParams.userID = userID;
        
        //redirect to user edit
        $location.path('index/usersEdit').search($stateParams);
    }

}
function usersDetailsCtrl($scope, $location, $http) {
    var userID = $location.search().userID;

    $scope.displayUserDetails = function()
    {
        displayDetails($scope, $http, $location, userID);
    }


    $scope.back = function() {
        backToSummary($location);
    }
}


function displayDetails($scope, $http, $location, userID){

    $scope.users = {};    
    $http.post("../Controller/UsersController.php", 
        {
            "method" : "getDetails",
            "userID" : userID
        })
        .then(function(response) {
            $scope.users.userID = response.data.userID;
            $scope.users.first_name = response.data.firstName;
            $scope.users.middle_name = response.data.middleName;
            $scope.users.last_name = response.data.lastName;
            $scope.users.userTypeID = response.data.userTypeID;
            $scope.users.userType = response.data.userType;
            $scope.users.username = response.data.userName;
            $scope.users.password = response.data.password;
            $scope.users.areaID = response.data.areaID;
            $scope.users.areaName = response.data.areaName;
            $scope.users.dateCreated = response.data.dateCreated;
            $scope.users.remarks = response.data.remarks;
            $scope.users.status = response.data.status;
            $scope.users.parentUserID = response.data.parentUserID;
            $scope.users.parentUserFullname = response.data.parentUserFullname;
        })
}

function backToSummary($location) {
    $location.path('index/users');
}

function usersAddCtrl($scope, $location, $http) {
    $scope.users = {};    
    populateForms($http, $scope, "add");

    $scope.modifyRecord = function() {
        modifyDBRecord("add", $scope, $location, $http);
    }

    $scope.back = function() {
        backToSummary($location);
    }
}

function usersEditCtrl($scope, $location, $http) {
    $scope.users = {};    
    var userID = $location.search().userID;

    $scope.displayUserDetails = function()
    {
        displayDetails($scope, $http, $location, userID);
        populateForms($http, $scope, "edit"); 
    }

    $scope.modifyRecord = function() {

        modifyDBRecord("edit", $scope, $location, $http);
    }

    $scope.back = function() {
        backToSummary($location);
    }
}

function modifyDBRecord(pMethod, $scope, $location, $http) {

    $http.post("../Controller/UsersController.php", 
        {
            "method" : pMethod,
            "userID" : $scope.users.userID,
            "firstName": $scope.users.first_name,
            "middleName": $scope.users.middle_name,
            "lastName": $scope.users.last_name,
            "userTypeID": $scope.users.selectedOption.USER_TYPE_ID,
            "username": $scope.users.username,
            "password": md5($scope.users.password),
            "areaID": $scope.area.selectedOption.AREA_ID,
            "status": $scope.users.status,
            "remarks": $scope.users.remarks,
            "parentUserID": $scope.users.selectedOption.PARENT_USER_ID

        })
        .then(function(response) {
            
            if(response.data.result == 1)
            {
                //successfully added to database
                backToSummary($location);
            }
        })
}

//populate the needed forms coming from lookup tables
function populateForms($http, $scope, method) {

    //1. USER TYPE
    $http.post("../Controller/UserTypesController.php", {
            method: "displayActiveUserTypes"
        })
        .then(function(response) {
            $scope.usersTypes = response.data;

            if(method == "add") {
                //set the frequency to 1 by default only

                //set the assigned record to index 1
                $scope.usersTypes.selectedOption = $scope.usersTypes[0];
                
            }
            
            else if(method == "edit") {
                //compare now and then highlight the assigned records
                for(var i = 0; i< $scope.usersTypes.length; i++) {
                    if($scope.usersTypes.USER_TYPE_ID == $scope.usersTypes[i].USER_TYPE_ID) {
                        $scope.usersTypes.selectedOption = $scope.usersTypes[i];
                        break;
                    }
                }
            }
        })  

    //2. AREA
    $http.post("../Controller/AreaController.php", {
            method: "displayArea"
        })
        .then(function(response) {
            $scope.area = response.data;
            
            if(method == "add") {
                //set the frequency to 1 by default only

                //set the assigned record to index 1
                $scope.area.selectedOption = $scope.area[0];
            }
            
            else if(method == "edit") {
                //compare now and then highlight the assigned records
                for(var i = 0; i< $scope.area.length; i++) {
                    if($scope.area.AREA_ID == $scope.area[i].AREA_ID) {
                        $scope.area.selectedOption = $scope.area[i];
                        break;
                    }
                }
            }
        })

    //3. ASSIGNED TO

    //ASSIGNED TO
    $http.post("../Controller/UsersController.php", {
            method: "displayAllUsers"
        })
        .then(function(response) {
            $scope.users = response.data;

            if(method == "add") {
                //set the frequency to 1 by default only

                //set the assigned record to index 1
                $scope.users.selectedOption = $scope.users[0];
            }
            
            else if(method == "edit") {
                //compare now and then highlight the assigned records
                for(var i = 0; i< $scope.users.length; i++) {
                    if($scope.users.USER_ID == $scope.users[i].USER_ID) {
                        $scope.users.selectedOption = $scope.users[i];
                        break;
                    }
                }
            }
        })       
}