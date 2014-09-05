var poengFilters = angular.module('poengFilters', []);

poengFilters.filter('myPersons', function () {
  return function (persons, selectedGroup) {
    console.log("Filtering " + persons.length + " persons for group " + selectedGroup.id);
    var filtered = [];
    var i = 0;
    if (selectedGroup.id === 0) {
      return persons;
    }
    for (i = 0; i < persons.length; i++) {
      console.log("Is " + persons[i].name + "(" + persons[i].group_id + ") in the group " + selectedGroup.name);
      if (persons[i].group_id == selectedGroup.id) {
        filtered.push(persons[i]);
        console.log("Added: " + persons[i].name);
      }
    }
    return filtered;
  };
});