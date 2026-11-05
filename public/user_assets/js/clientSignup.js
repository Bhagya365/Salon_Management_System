// validation

// Allow only digits in contact number
document.addEventListener("DOMContentLoaded", function() {

  const contactNo = document.getElementById("contactNo");

  contactNo.addEventListener("input", function() {
    this.value = this.value.replace(/[^0-9]/g, "");
  });
  

  // Allow only letters in first name and last name
  const fName = document.getElementById("fName");
  const lName = document.getElementById("lName");

  function allowOnlyLetters(input) {
    input.value = input.value.replace(/[^A-Za-z]/g, "");
  }

  fName.addEventListener("input", function() {
    allowOnlyLetters(this);
  });

  lName.addEventListener("input", function() {
    allowOnlyLetters(this);
  });







});