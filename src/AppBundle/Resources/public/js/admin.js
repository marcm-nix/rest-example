document.addEventListener("DOMContentLoaded", function() {


var tokenBtn = document.getElementById('get-token');

var tokenInput = document.getElementById('appbundle_users_token');
var tokenUrl = document.getElementById('get-token').getAttribute('data-url');

var request = new XMLHttpRequest();

request.onreadystatechange = function() {
  if(request.readyState === 4) {
    if(request.status === 200) {
      var response = request.responseText;
        jsonRes = JSON.parse(response)
        tokenInput.value = jsonRes.token;
        }
    }
}




tokenBtn.addEventListener("click", function(e) {
    e.preventDefault();
    request.open('Get', tokenUrl);
    request.send();
}); 



});
