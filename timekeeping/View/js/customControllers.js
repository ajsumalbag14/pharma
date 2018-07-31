
//perform a security check of the session


/*
function assignDoctorsCtrl($scope, $http, $uibModal, sessionService) {
    $scope.searchDoctor = function() {
        $http.post("../Controller/DoctorsVisitController.php", 
        {
            "method" : "displayDoctorsVisitPerUser",
            "userID" : sessionService.get("userID")
        })
        .then(function(response) {
            $scope.doctorsVisit = response.data;
        })

    }
}
*/



// function displayArea($scope, $http) {
//     //alert('display area in here');

//     $http.post("../Controller/AreaController.php", 
//         {
//             "method" : "displayArea"
//         }
//     )
//     .then(function(response) {
//         $scope.areas = response.data;
//     })
// }

angular
    .module('inspinia')
//    .controller('assignDoctorsCtrl', assignDoctorsCtrl)

    
    
    
