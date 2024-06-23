function toggleDescription(id) {
    var dots = document.getElementById("dots_" + id);
    var moreText = document.getElementById("more_" + id);
    var btnText = document.getElementById("btn_" + id);

    if (dots.style.display === "none") {
      dots.style.display = "inline";
      btnText.innerHTML = "Развернуть";
      moreText.style.display = "none";
    } else {
      dots.style.display = "none";
      btnText.innerHTML = "Свернуть";
      moreText.style.display = "inline";
    }
  }