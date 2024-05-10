$(document).ready(function () {
  $("#mybtn").submit(function (event) {
    event.preventDefault();
    var Data = {
      Username: $("input[name=Username]").val(),
      Email: $("input[name=Email]").val(),
      Password: $("input[name=Password]").val(),
    };
    console.log("clicked");
    $.ajax({
      url: "http://localhost/MY%20PROJECTS/RESUME%20BUILDER/Task/php/login.php",
      type: "POST",
      data: Data,
      dataType: "json",
      success: function (response) {
        if (response.success == true) {
          localStorage.setItem("token", response.token);
          window.location.href = "profile.html";
        } else {
          alert(response.message);
        }
      },
    });
  });
});
