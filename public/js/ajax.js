function handleAjaxError(jqXHR, textStatus, errorThrown) {
  console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
  Swal.fire({
    title: "AJAX error !",
    text: "Please try again. (" + textStatus + " : " + jqXHR.responseText + ")",
    icon: "error",
  });
}

function handleAjaxResponse(action, response, successTitle, successMessage, logout) {
  switch (action) {
    case 'login':
      console.log("on va vers first-login")
      redirectHref = "first-login"
      break;
    case 'first-login':
      redirectHref = "home"
      break;
    case 'update':
      redirectHref = "update"
      break;
    default:
      redirectHref = "login"
      break;
  }
  if (response.success) {
    Swal.fire({
      title: successTitle,
      text: successMessage,
      icon: "success",
    }).then(function () {
      if (redirectHref != "update") {
        window.location.href = redirectHref;
      }
      else {
        window.location.reload(true);
      }
    });
    if (!logout) {
      $("#form-data")[0].reset();
    }
  } else {
    Swal.fire({
      title: "Operation failed!",
      text: response.message,
      icon: "error",
    });
  }
}



function performAjaxRequest(
  requestType,
  action,
  additionalData,
  successTitle,
  successMessage
) {
  $.ajax({
    url: "index.php",
    type: requestType,
    data: $("#form-data").serialize() + "&action=" + action + additionalData,
    dataType: "json",
    success: function (response) {
      if (action == "showAllRecipes") {
        $("#RecipeList").html(response.message);
        $("table").DataTable({ order: [2, "desc"] });
      }
      else if (action == "showAllUsers") {
        $("#showUser").html(response.message);
        $("table").DataTable({ order: [0, "desc"] });
      }
      else {
        console.log("action: " + action)
        handleAjaxResponse(action, response, successTitle, successMessage, action == "logout");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      handleAjaxError(jqXHR, textStatus, errorThrown);
    },
  });
}
