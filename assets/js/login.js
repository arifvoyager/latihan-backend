window.addEventListener("load", function () {
  function sendData() {
    var XHR = new XMLHttpRequest();

    var FD = new FormData(form);

    XHR.addEventListener("load", function(event) {
          var data = JSON.parse(event.target.responseText);
          if(data.isLoggedIn == "true"){    
            if(!alert("Log In Success")){
              window.location.reload();
            }
          }
          else if(data.isLoggedIn == "false"){    
            if(!alert(data.message)){
              window.location.reload();
            }
          }
        
    });

    XHR.addEventListener("error", function(event) {
        alert('Oops! Something went wrong.');
    });

    XHR.open("POST", "https://mountable.id/API/login");
    XHR.send(FD);
  }
 

  var form = document.getElementById("loginForm");

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    sendData();
  });
});