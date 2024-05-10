$(document).ready(function () {
  var authToken = localStorage.getItem("token");
  if (!authToken) {
    alert("session expired");
    window.location.href = "login.html";
    return;
  }

  $.ajax({
    url: "http://localhost/MY%20PROJECTS/RESUME%20BUILDER/Task/php/profile.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.success == true) {
        $("input[name=Username]").val(response.data.Username);
        $("input[name=Email]").val(response.data.Email);
        $("input[name=Age]").val(response.data.Age);
        $("input[name=Dob]").val(response.data.Dob);
        $("input[name=Contact]").val(response.data.Contact);
      } else {
        alert(response.message);
      }
    },
  });
});

$("#mybtn").click(function (event) {
  event.preventDefault();

  var Data = {
    Username: $("input[name=Username]").val(),
    Email: $("input[name=Email]").val(),
    Age: $("input[name=Age]").val(),
    Dob: $("input[name=Dob]").val(),
    Contact: $("input[name=Contact]").val(),
  };

  console.log(Data);
  $.ajax({
    url: "http://localhost/MY%20PROJECTS/RESUME%20BUILDER/Task/php/profile.php",
    type: "POST",
    data: Data,
    dataType: "json",
    success: function (response) {
      if (response.success == true) {
        alert("successfully updated the profile");
      } else {
        alert(response.message);
      }
    },
  });
});

function logout() {
  localStorage.clear();
  alert("Logged out successfully");
  window.location.href = "login.html";
}
