function doctorsVisitCtrl($scope, $http, $uibModal, sessionService) {

    $scope.displayDoctorsVisitPerUser = function() {
        $http.post("../Controller/DoctorsVisitController.php", 
        {
            "method" : "displayDoctorsVisitPerUser",
            "userID" : sessionService.get("userID")
        })
        .then(function(response) {
            $scope.doctorsVisit = response.data;
        })
    }

    //method to display modal
    $scope.displayModal = function (method, doctorVisitID) {
        
        //view modal
        var modalInstance = $uibModal.open({
            templateUrl: 'views/doctorVisitDetails.html',
            size: 'lg',
            controller: doctorVisitModalCtrl,
            resolve: {
                pMethod: function(){ return method; },
                doctorVisitID: function() { return doctorVisitID }
            }
        }); 
    };

    //method to display modal for Area Manager
    $scope.displayAMModal = function (method, AMActivityID) {
        
        //view modal
        var modalInstance = $uibModal.open({
            templateUrl: 'views/AMActivityDetails.html',
            size: 'lg',
            controller: AMActivityModalCtrl,
            resolve: {
                pMethod: function(){ return method; },
                AMActivityID: function() { return AMActivityID }
            }
        }); 
    };

    function AMActivityModalCtrl($http, $scope, $uibModalInstance, pMethod, AMActivityID) {
          $scope.displayPopupAMActivity = function() {

            $http.post("../Controller/AMActivityController.php", 
            {
                "method" : "getAMActivityDetails",
                "AMActivityID" : AMActivityID
            })
            .then(function(response) {

                $scope.AMActivityID = response.data[0].AREA_MANAGER_ACTIVITY_ID;
                $scope.userID = response.data[0].USER_ID;
                $scope.activityDatetime = response.data[0].ACTIVITY_DATETIME;
                $scope.activityType = response.data[0].ACTIVITY_TYPE;
                $scope.locationLat = response.data[0].LOCATION_LAT;
                $scope.locationLong = response.data[0].LOCATION_LONG;
                $scope.remarks = response.data[0].REMARKS;           

                initMapAM($scope.locationLat, $scope.locationLong);
            })
        } 

        function initMapAM (locationLat, locationLong) {
            var vLocationLat = parseFloat(locationLat);
            var vLocationLong = parseFloat(locationLong);

            var myLatLng = {
                lat: vLocationLat,
                lng: vLocationLong
            }
            var map;      
            map = new google.maps.Map(document.getElementById('mapAM'), {
            center: {
                    lat: vLocationLat,
                    lng: vLocationLong
                },
            gestureHandling: 'cooperative',
            zoom: 14
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Location'
            });
    }
    
    
    }

    //ok button is pressed.
        $scope.ok = function () {
            $uibModalInstance.close();
        };

    $scope.displayAMActivity = function() {
        $http.post("../Controller/AMActivityController.php", 
        {
            "method" : "displayAMActivity",
            "userID" : sessionService.get("userID")
        })
        .then(function(response) {
            $scope.AMActivity = response.data;
        })

    }

    
}

//display modal of doctors visit
function doctorVisitModalCtrl($http, $scope, $uibModalInstance, pMethod, doctorVisitID) {
    $scope.displayPopup = function() {
        $http.post("../Controller/DoctorsVisitController.php", 
        {
            "method" : "getDoctorVisitDetails",
            "doctorVisitID" : doctorVisitID
        })
        .then(function(response) {
            $scope.doctorVisitID = response.data[0].DOCTOR_VISIT_ID;
            $scope.userID = response.data[0].USER_ID;
            $scope.doctorID = response.data[0].DOCTOR_ID;
            $scope.visitDatetime = response.data[0].VISIT_DATETIME;
            $scope.doctorSignature = response.data[0].DOCTOR_SIGNATURE;
            $scope.doctorSignatureFileType = response.data[0].DOCTOR_SIGNATURE_FILE_TYPE;
            $scope.locationLat = response.data[0].LOCATION_LAT;
            $scope.locationLong = response.data[0].LOCATION_LONG;
            $scope.remarks = response.data[0].REMARKS;           

            initMap($scope.locationLat, $scope.locationLong);
        })
    } 
      
        function initMap (locationLat, locationLong) {
            var vLocationLat = parseFloat(locationLat);
            var vLocationLong = parseFloat(locationLong);

            var myLatLng = {
                lat: vLocationLat,
                lng: vLocationLong
            }
            var map;      
            map = new google.maps.Map(document.getElementById('map'), {
            center: {
                    lat: vLocationLat,
                    lng: vLocationLong
                },
            gestureHandling: 'cooperative',
            zoom: 14
        });
        
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Location'
            });
        }

    //ok button is pressed.
        $scope.ok = function () {
            $uibModalInstance.close();
        };
}

//angular
    //.controller('doctorsVisitCtrl', doctorsVisitCtrl)