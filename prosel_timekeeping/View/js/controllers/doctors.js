function doctorCtrl($scope, $http, sessionService, $location, $stateParams) {
    //check for authentication
    if(!sessionService.get("userID")) //not authenticated
    {
        $location.path('/login');
    }

    $scope.displayDoctors = function() {
        //check if the logged in user is admin
        //if admin, display all doctors
        //else if dsm - display all that is assigned per dsm only

        var userType = sessionService.get("userType");
        var userID = sessionService.get("userID");
        var options = "";

        if(userType== "Administrator")
        {
            options = {
                method: "displayDoctors"
            }
        }
        else if (userType == "DSM")
        {
            options = {
                method: "displayDoctorsPerDSM",
                userID: userID
            }
        }

        $http.post("../Controller/DoctorController.php", options)
        .then(function(response) {
            $scope.doctors = response.data;
        })
    }

    $scope.displayDetails = function(doctorID) 
    {
        $stateParams.doctorID = doctorID;
        
        //redirect to doctor details
        $location.path('index/doctorDetails').search($stateParams);
    }

    $scope.addRecord = function() {
        //redirect to doctor add page
        $location.path('index/doctorAdd');
    }

    $scope.editRecord = function(doctorID) 
    {
        $stateParams.doctorID = doctorID;
        
        //redirect to doctor edit
        $location.path('index/doctorEdit').search($stateParams);
    }
}

function doctorDetailsCtrl($scope, $location, $http){
    var doctorID = $location.search().doctorID;

    $scope.displayDoctorDetails = function()
    {
        displayDetails($scope, $http, $location, doctorID);
    }

    $scope.displayDoctorBalance = function() {

        $http.post("../Controller/DoctorBalanceController.php", 
        {
            "method" : "displayDoctorBalance",
            "doctorID" : doctorID
        })
        .then(function(response) {
            //$scope.doctor = response.data;
            $scope.balance = response.data[0].BALANCE;
            $scope.balanceExpirationDate = response.data[0].BALANCE_EXPIRATION_DATE;  
        })
    }

    $scope.back = function() {
        backToSummary($location);
    }
}

function displayDetails($scope, $http, $location, doctorID){
    $scope.doctors = {};    
    $http.post("../Controller/DoctorController.php", 
        {
            "method" : "getDetails",
            "doctorID" : doctorID
        })
        .then(function(response) {
            $scope.doctors.DOCTOR_ID = response.data[0].DOCTOR_ID;
            $scope.doctors.FIRST_NAME = response.data[0].FIRST_NAME;
            $scope.doctors.MIDDLE_INITIAL = response.data[0].MIDDLE_INITIAL;
            $scope.doctors.LAST_NAME = response.data[0].LAST_NAME;
            $scope.doctors.DOCTOR_SPECIALTY_ID = response.data[0].DOCTOR_SPECIALTY_ID;
            $scope.doctors.ADDRESS1 = response.data[0].ADDRESS1;
            $scope.doctors.ADDRESS2 = response.data[0].ADDRESS2;
            $scope.doctors.FREQUENCY = response.data[0].FREQUENCY;
            $scope.doctors.USER_ID = response.data[0].USER_ID;
        })
}

function backToSummary($location) {
    $location.path('index/doctor');
}

function doctorAddCtrl($scope, $location, $http) {
    $scope.doctors = {};    
    populateForms($http, $scope, "add");

    $scope.modifyRecord = function() {

        modifyDBRecord("add", $scope, $location, $http);

    }

    $scope.back = function() {
        backToSummary($location);
    }
}

function modifyDBRecord(pMethod, $scope, $location, $http) {
    $http.post("../Controller/DoctorController.php", 
        {
            "method" : pMethod,
            "DOCTOR_ID" : $scope.doctors.DOCTOR_ID,
            "FIRST_NAME": $scope.doctors.FIRST_NAME,
            "MIDDLE_INITIAL": $scope.doctors.MIDDLE_INITIAL,
            "LAST_NAME": $scope.doctors.LAST_NAME,
            "DOCTOR_SPECIALTY_ID": $scope.doctors.DOCTOR_SPECIALTY_ID,
            "ADDRESS1": $scope.doctors.ADDRESS1,
            "ADDRESS2": $scope.doctors.ADDRESS2,
            "FREQUENCY": $scope.doctors.FREQUENCY,
            "USER_ID": $scope.doctors.selectedOption.USER_ID
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

    //ASSIGNED TO
    $http.post("../Controller/UsersController.php", {
            method: "displayAllUsers"
        })
        .then(function(response) {
            $scope.users = response.data;

            if(method == "add") {
                //set the frequency to 1 by default only

                //set the assigned record to index 1
                $scope.doctors.selectedOption = $scope.users[0];
            }
            
            else if(method == "edit") {
                //compare now and then highlight the assigned doctors
                for(var i = 0; i< $scope.users.length; i++) {
                    if($scope.doctors.USER_ID == $scope.users[i].USER_ID) {
                        $scope.doctors.selectedOption = $scope.users[i];
                        break;
                    }
                }
            }
        })       
}

function doctorEditCtrl($scope, $location, $http) {
    $scope.doctors = {};    
    var doctorID = $location.search().doctorID;

    $scope.displayDoctorDetails = function()
    {
        displayDetails($scope, $http, $location, doctorID);
        populateForms($http, $scope, "edit"); 
    }

    $scope.modifyRecord = function() {
        modifyDBRecord("edit", $scope, $location, $http);
    }

    $scope.back = function() {
        backToSummary($location);
    }
}