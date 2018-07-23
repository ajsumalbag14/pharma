/**
 * INSPINIA - Responsive Admin Theme
 *
 * Inspinia theme use AngularUI Router to manage routing and views
 * Each view are defined as state.
 * Initial there are written state for all view in theme.
 *
 */
function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider) {
    $urlRouterProvider.otherwise("/index/main"); //sets the default route
    
    $ocLazyLoadProvider.config({
        // Set to true if you want to see what and when is dynamically loaded
        debug: false
    });

    $stateProvider

        .state('index', {
            abstract: true,
            url: "/index",
            templateUrl: "views/common/content.html",
        })
        .state('index.main', {
            url: "/main",
            templateUrl: "views/main.html",
            data: { pageTitle: 'Dashboard' },
            controller: indexCtrl
        })
        /*.state('index.minor', {
            url: "/minor",
            templateUrl: "views/minor.html",
            data: { pageTitle: 'Example view' }
        })
        */
        .state('login', {
            url: "/login",
            templateUrl: "views/login.html",
            data: { pageTitle: 'Login', specialClass: 'gray-bg' },
            controller: loginCtrl,
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/md5.js']
                        }
                    ]);
                }
            }
        })

        .state('logout', {
            url: "/logout",
            templateUrl: "views/login.html",
            data: { pageTitle: 'Login', specialClass: 'gray-bg' },
            controller: logoutCtrl
        })

        //doctors start

        .state('index.doctor', {
            url: "/doctor",
            templateUrl: "views/doctor.html",
            data: { pageTitle: 'Doctor'},
            controller: doctorCtrl
        })

        .state('index.doctorDetails', {
            url: "/doctorDetails",
            templateUrl: "views/doctorDetails.html",
            data: { pageTitle: 'Doctor Details'},
            controller: doctorDetailsCtrl
        })

        .state('index.doctorAdd', {
            url: "/doctorAdd",
            templateUrl: "views/doctorModify.html",
            data: { pageTitle: 'Add Doctor'},
            controller: doctorAddCtrl
        })

        .state('index.doctorEdit', {
            url: "/doctorEdit",
            templateUrl: "views/doctorModify.html",
            data: { pageTitle: 'Edit Doctor'},
            controller: doctorEditCtrl
        })        

        //doctors end

        .state('index.modules', {
            url: "/modules",
            templateUrl: "views/modules.html",
            data: { pageTitle: 'Web Modules'},
            controller: modulesCtrl
        })

        .state('index.products', {
            url: "/products",
            templateUrl: "views/products.html",
            data: { pageTitle: 'Products'},
            controller: productsCtrl
        })

        .state('index.areaManager', {
            url: "/areaManager",
            templateUrl: "views/areaManager.html",
            data: { pageTitle: 'Area Manager'},
            controller: areaManagerCtrl
        })

        .state('index.AMDetails', {
            url: "/AMDetails",
            templateUrl: "views/AMDetails.html",
            data: { pageTitle: 'Area Manager Details'},
            controller: AMDetailsCtrl
        })

        .state('index.AMActivity', {
            url: "/AMActivity",
            templateUrl: "views/AMActivity.html",
            data: { pageTitle: 'Area Manager Activity'},
            controller: areaManagerActivityCtrl
        })

        //users start

        .state('index.users', {
            url: "/users",
            templateUrl: "views/users.html",
            data: { pageTitle: 'Sales Agent'},
            controller: usersCtrl
        })

        .state('index.userDetails', {
            url: "/userDetails",
            templateUrl: "views/userDetails.html",
            data: { pageTitle: 'User Details'},
            controller: usersDetailsCtrl
        })

        .state('index.usersAdd', {
            url: "/usersAdd",
            templateUrl: "views/usersModify.html",
            data: { pageTitle: 'Add User'},
            controller: usersAddCtrl,
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/md5.js']
                        }
                    ]);
                }
            }
        })

        .state('index.usersEdit', {
            url: "/usersEdit",
            templateUrl: "views/usersModify.html",
            data: { pageTitle: 'Edit User'},
            controller: usersEditCtrl,
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/md5.js']
                        }
                    ]);
                }
            }
        })     

        //users end

         .state('index.doctorsVisitDetailsPerAM', {
            url: "/doctorsVisitDetailsPerAM",
            templateUrl: "views/doctorsVisitDetailsPerAM.html",
            data: { pageTitle: 'Doctors Visit Details Per Area Manager'},
            controller: doctorsVisitDetailsPerAMCtrl
        })

        .state('index.doctorsVisit', {
            url: "/doctorsVisit",
            templateUrl: "views/doctorsVisit.html",
            data: { pageTitle: 'Doctors Visit'},
            controller: doctorsVisitCtrl
            
        })

        .state('index.doctorsVisitDetails', {
            url: "/doctorsVisitDetails",
            templateUrl: "views/doctorsVisitDetails.html",
            data: { pageTitle: 'Doctors Visit Details'},
            controller: doctorsVisitDetailsCtrl
            
        })
}
angular
    .module('inspinia')
    .config(config)
    .run(function($rootScope, $state) {
        $rootScope.$state = $state;
    });
