function search_orders() {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('search-order');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
  
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }

  var openmodal = document.querySelectorAll(".modal-open");
  for (var i = 0; i < openmodal.length; i++) {
    openmodal[i].addEventListener("click", function(event) {
      event.preventDefault();
      toggleModal();
    });
  }
  
  const overlay = document.querySelector(".modal-overlay");
  overlay.addEventListener("click", toggleModal);
  
  const accept = document.querySelector(".modal-accept");
  accept.addEventListener("click", acceptCookies);
  
  var closemodal = document.querySelectorAll(".modal-close");
  for (var i = 0; i < closemodal.length; i++) {
    closemodal[i].addEventListener("click", toggleModal);
  }
  
  document.onkeydown = function(evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) {
      isEscape = evt.key === "Escape" || evt.key === "Esc";
    } else {
      isEscape = evt.keyCode === 27;
    }
    if (isEscape && document.body.classList.contains("modal-active")) {
      toggleModal();
    }
  };
  
  function toggleModal() {
    const body = document.querySelector("body");
    const modal = document.querySelector(".modal");
    modal.classList.toggle("opacity-0");
    modal.classList.toggle("pointer-events-none");
    body.classList.toggle("modal-active");
  }
  
  function acceptCookies() {
    // provide visitor a "user-given consent" receipt for accepting cookies
    Cookies.set("accepted-cookies-consent", true, { expires: 7 });
    // just to show when the cookie was added
    Cookies.set("accepted-cookies-consent-timestamp", Date.now(), { expires: 7 });
  }
  