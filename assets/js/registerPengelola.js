window.addEventListener("load", function () {
    function sendData() {
      var XHR = new XMLHttpRequest();
  
      // Bind the FormData object and the form element
      var FD = new FormData(form);
  
      // Define what happens on successful data submission
      XHR.addEventListener("load", function(event) {
        if(!alert(event.target.responseText)){
          if(event.target.responseText == '"Berhasil Registrasi"'){
            window.location.href = "https://mountable.id/pages/login";
          }
        }
      });
  
      // Define what happens in case of error
      XHR.addEventListener("error", function(event) {
          alert('Oops! Something went wrong.');
      });
  
      // Set up our request
      XHR.open("POST", "https://mountable.id/API/reg_pengelola");
      // The data sent is what the user provided in the form
      XHR.send(FD);
    }
   
    // Access the form element...
    var form = document.getElementById("form");
  
    // ...and take over its submit event.
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      sendData();
    });
  });