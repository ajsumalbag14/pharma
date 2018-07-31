function sessionService($window) {
    var service = this;
    var sessionStorage = $window.sessionStorage;

    service.get = function(key) {
        return sessionStorage.getItem(key);
    };

    service.set = function(key, value) {
        sessionStorage.setItem(key, value);
    };

    service.unset = function(key) {
        sessionStorage.removeItem(key);
    };    
}

angular
    .module('inspinia')
    .service('sessionService', sessionService)
    