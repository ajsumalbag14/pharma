function areaManagerActivityCtrl($scope, $location, $http, sessionService, $stateParams){
    var userID = $location.search().userID;
    var firstName = $location.search().firstName;
    var lastName = $location.search().lastName;

    var fullName = firstName + " " + lastName;

    //alert(fullName);

    $scope.displayAMActivity = function()
    {
        $http.post("../Controller/AMActivityController.php", 
        {
            "method" : "displayAMActivity",
            "userID" : userID
        })
        .then(function(response) {

            $scope.AMActivity = response.data; //grid view
            $scope.fullName = fullName;
        })
    }
    
    $scope.backToAMSummary = function() {
        $location.path('index/areaManager');
    }

    $scope.backToAMDetails = function() {
        $location.path('index/AMDetails');
    }


    $scope.displayAMActivityDetails = function(AMActivityID) 
    {
        //alert(AMActivityID);
        $http.post("../Controller/AMActivityController.php", 
        {
            "method" : "getAMActivityDetails",
            "AMActivityID" : AMActivityID
        })
        .then(function(response) {
            $scope.areaManagerActivityID = response.data[0].AREA_MANAGER_ACTIVITY_ID;
            $scope.activityDateTime = response.data[0].ACTIVITY_DATETIME;
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
        map = new google.maps.Map(document.getElementById('mapAM'), {
        center: {
                lat: vLocationLat,
                lng: vLocationLong
            },
        gestureHandling: 'cooperative',
        zoom: 16
    });
    
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Location'
    });
    
    }



}