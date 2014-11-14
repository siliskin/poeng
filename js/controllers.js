var poengControllers = angular.module('poengController', []);

poengControllers.controller('RegisterCtrl', function ($scope, $http, $location) {
  $scope.date = new Date();
  $scope.groups = [{name: "Alle", id: 0},
    {name: "A-gruppa", id: 1},
    {name: "B-gruppa", id: 2},
    {name: "C-gruppa", id: 3},
    {name: "D-gruppa", id: 4}];
  $scope.groupSelected = $scope.groups[0];
  $scope.persons = [];
  $scope.attendance = [];

  $http.get('api/attendance.php/users/group/' + $scope.groupSelected.id).success(function (data) {

    $scope.persons = data;

    for (var i = 0; i < $scope.persons.length;i++) {
      $scope.attendance.push(
        {id: $scope.persons[i].id,
         name: $scope.persons[i].name,
         group_id: $scope.persons[i].group_id,
         comment: "",
         attended: false});
    }
  });

  $scope.getDayName = function (date) {
    var daynames = ["Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag"];
    return daynames[date.getDay()];
  };

  $scope.convertDate = function (date) {
    return date.getFullYear() + '-' +
    (date.getMonth() < 9 ? '0' : '') + (date.getMonth()+1) + '-' +
    (date.getDate() < 10 ? '0' : '') + date.getDate();
  };

  $scope.getGroup = function () {
    console.log("Get group: " + $scope.groupSelected.name);
    // $http.get('api/attendance.php/users/group/'+$scope.groupSelected.id).success(function(data) {
    //   $scope.persons = data;
    // });
    if (!$scope.$$phase) {
      $scope.$apply();
    }
  };

  $scope.sendAttendance = function () {
    console.log("Set attendance: " + $scope.convertDate($scope.date));
    $http({url: 'api/attendance.php/attendance/' + $scope.convertDate($scope.date),
      method: "POST",
      data: $scope.attendance,
      headers: {'Content-Type': 'application/json'}}).
    success(function (data, status, headers, config) {
      console.log("Success: " + data);
    }).
    error(function (data, status, headers, config) {
      console.log("Error: " + JSON.stringify(config));
    });

    $location.path('/review');

  };
});
