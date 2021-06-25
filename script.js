var keyword = document.getElementById('keyword')
var tcari = document.getElementById('tcari')
var content = document.getElementById('content')

keyword.addEventListener('keyup', function() {
  tcari.style.display = "none"
  
  var xhr = new XMLHttpRequest()
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      content.innerHTML = xhr.responseText
    }
  }
  xhr.open('GET', 'peserta.php?keyword=' + keyword.value, true)
  xhr.send()
  
})
