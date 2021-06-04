function toggle_visibility(id) {
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