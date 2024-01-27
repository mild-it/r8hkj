function showdisPMJ(str) {
  if (str.length == 0) {
    document.getElementById("showdis").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("showdis").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "listPMJ.php?q="+str, true);
    xmlhttp.send();
  }
}

function showdisOBT(str) {
  if (str.length == 0) {
    document.getElementById("showdis").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("showdis").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "listOBT.php?q="+str, true);
    xmlhttp.send();
  }
}

function showdisPaper(str) {
  if (str.length == 0) {
    document.getElementById("showdis").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("showdis").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "listPaper.php?q="+str, true);
    xmlhttp.send();
  }
}

function showdisOK(str) {
  if (str.length == 0) {
    document.getElementById("showdis").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("showdis").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "listOK.php?q="+str, true);
    xmlhttp.send();
  }
}

function showdisHOS(str) {
  if (str.length == 0) {
    document.getElementById("showdis").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("showdis").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "listHOS.php?q="+str, true);
    xmlhttp.send();
  }
}
