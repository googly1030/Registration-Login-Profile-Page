$(document).ready(function () {
  $("#mybtn").submit(function (event) {
    event.preventDefault();
    console.log("clicked");
    var Data = {
      Username: $("input[name=Username]").val(),
      Email: $("input[name=Email]").val(),
      Password: $("input[name=Password]").val(),
    };
    $.ajax({
      url: "http://localhost/MY%20PROJECTS/RESUME%20BUILDER/Task/php/register.php",
      type: "POST",
      data: Data,
      dataType: "json",
      success: function (response) {
        if (response.success == true) {
          window.location.href = "login.html";
        } else {
          alert(response.message);
        }
      },
      error: function (error) {
        console.log(error);
      },
    });
  });
});
