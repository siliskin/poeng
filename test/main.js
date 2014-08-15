// The root URL for the RESTful services

var rootURL = "http://localhost/index.php/people/user";

$("#btnForm").click(function( event ) {
  addUser(event);
});

function addUser(event) {
  console.log('addUser');
  $.ajax({
    type: 'POST',
    contentType: 'application/json',
    url: rootURL,
    dataType: "json",
    data: formToJSON(),
    success: function(data, textStatus, jqXHR){
      alert('User created successfully');
      event.preventDefault();
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert('addWine error: ' + textStatus);
    }
  });
}

// Helper function to serialize all the form fields into a JSON string
function formToJSON() {
  return JSON.stringify({
    "name": $('#name').val(),
    "group_id": $('#group_id').val(),
    "year": $('#year').val(),
    "sex": $('#sex').val(),
    "image_path": $('#image_path').val(),
    });
}
