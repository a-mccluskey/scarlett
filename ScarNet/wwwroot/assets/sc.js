function toggle_visibility(id) 
{
  var e = document.getElementById(id);
  if(e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block';
}
function UpdateImage() 
{
  var imageID = document.getElementById('txt_thumb').value;
  document.getElementById('imgPreview').src = domain+"render.php?id="+imageID+"&s=p";
}
function startTouch(e) {
  initialX = e.touches[0].clientX;
  initialY = e.touches[0].clientY;
}
function moveTouch(e) {
  var previousLink = document.querySelector('#PreviousImg');
  var nextLink = document.querySelector('#NextImg');
  if (initialX === null) {
    return;
  }

  if (initialY === null) {
    return;
  }

  var currentX = e.touches[0].clientX;
  var currentY = e.touches[0].clientY;
  var diffX = initialX - currentX;
  var diffY = initialY - currentY;

  if (Math.abs(diffX) > Math.abs(diffY)) {
    // difference is in the left/right axis
    if (diffX > 0) {
      // swiped right to left
      if (nextLink) {
        window.location.href=document.querySelector('#NextImg');
      }
      else {
        return;
      }
    } 
    else {
      // swiped left to right
      if (previousLink) {
        window.location.href=document.querySelector('#PreviousImg');
      }
      else {
        return;
      }
    }
  }
  else {
    // we're not concerned by up down swiping
    return;
  }
  initialX = null;
  initialY = null;
  e.preventDefault();
}