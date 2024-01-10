const btn = document.querySelector("#change");
 
btn.addEventListener("change", () => {
  if (btn.checked == true) {
    document.body.classList.remove("lightTheme");
    document.body.classList.add("darkTheme");
  }

  else {
    document.body.classList.remove("darkTheme");
    document.body.classList.add("lightTheme");
  }
});
