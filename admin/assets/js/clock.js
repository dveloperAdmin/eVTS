let span = document.getElementById('clock_span');
let date_span = document.getElementById('date_span');
window.onload = displayClock();
function displayClock(){
  let display = new Date().toLocaleTimeString();
  let today = new Date();
  
  let date = today.getDate()+' - '+today.toLocaleString('en-us',{month:'short'})+' - '+today.toLocaleString('en-us',{year:'numeric'});
  
  date_span.innerHTML = date;
  span.innerHTML = display;
  setTimeout(displayClock, 1000); 
}