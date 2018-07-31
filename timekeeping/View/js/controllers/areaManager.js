function areaManagerCtrl($scope, $http, sessionService, $location, $stateParams) {
    //check for authentication

    $scope.displayAM = function() {
        //check if the logged in user is admin
        //if admin, display all am
        //else if dsm - display all that is assigned per dsm only

        var userType = sessionService.get("userType");
        var parentUserID = sessionService.get("userID");
        var options = "";

        if(userType== "admin") //display all records without looking for the parent user id
        {
            options = {
                method: "display"
            }
        }
        else if (userType != "AM") //if not AM, then display it using parent user id
        {
            options = {
                method: "displayAMPerParentUser",
                parentUserID: parentUserID
            }
        }

        var fullName = sessionService.get("firstName") + " " + sessionService.get("lastName");

        $scope.parentUserName = fullName;

        $http.post("../Controller/AMController.php", options)
        .then(function(response) {
            $scope.AreaManagers = response.data;
            
        })
    }

    $scope.displayDetails = function(userID) 
    {
        $stateParams.userID = userID;
        
        //redirect to am details page
        $location.path('index/AMDetails').search($stateParams);
    }
}

function AMDetailsCtrl($scope, $location, $http, $stateParams){
    var userID = $location.search().userID;

    $scope.displayAMDetails = function()
    {
        
        $http.post("../Controller/UsersController.php", 
        {
            "method" : "getDetails",
            "userID" : userID
        })
        .then(function(response) {
            $scope.userID = response.data.userID;
            $scope.firstName = response.data.firstName;
            $scope.middleInitial = response.data.middleName;
            $scope.lastName = response.data.lastName;
            $scope.userType = response.data.userType;
            $scope.userName = response.data.userName;
            $scope.areaName = response.data.areaName;
            $scope.dateCreated = response.data.dateCreated;
            $scope.remarks = response.data.remarks;
            $scope.status = response.data.status;
            $scope.parentUserFullname = response.data.parentUserFullname;
            
        })
    }
    
    $scope.back = function() {
        $location.path('index/areaManager');
    }

    $scope.displayAMActivity = function(userID, firstName, lastName) 
    {
        $stateParams.userID = userID;
        $stateParams.firstName = firstName;
        $stateParams.lastName = lastName;

        //alert(userID);        
        //redirect to am details page
        $location.path('index/AMActivity').search($stateParams);
    }

    $scope.displayDoctorsVisit = function(userID, firstName, lastName) 
    {
        $stateParams.userID = userID;
        $stateParams.firstName = firstName;
        $stateParams.lastName = lastName;

        //alert(userID);        
        //redirect to am details page
        $location.path('index/doctorsVisitDetailsPerAM').search($stateParams);
    }
    

}