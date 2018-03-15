$(document).ready(function()
{
  console.log("ready");
});

// This function is called by the form onsubmit attribute
// It should return false ONLY if my data is NOT VALID
// Otherwise it can return whatever
function validateForm()
{
  // Get values from required fields so that I can make sure they are there
  var make = $("#make").val();
  var model = $("#model").val();
  var year = $("#year").val();

  // If make, model, or year are empty, return false so the form does not submit
  if(make == "")
  {
    $("#make").css({border: "3px solid red"}); // Use this to make the box red
    alert("You must provide a make"); // Use this to let user know what went wrong
    return false; // Return false so the form does not submit
  }
  if(model == "")
  {
    $("#model").css({border: "3px solid red"});
    alert("You must provide a model");
    return false;
  }
  if(year == "")
  {
    $("#year").css({border: "3px solid red"});
    alert("You must provide a year");
    return false;
  }

  // Otherwise, return true so the form does submit
  return true;
}
