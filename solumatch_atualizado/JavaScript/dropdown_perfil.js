document.addEventListener("DOMContentLoaded", () => {
    const profileIcon = document.getElementById("profileIcon");
    const dropdownMenu = document.getElementById("dropdownMenu");

    profileIcon.addEventListener("click", (e) => {
      e.stopPropagation(); // impede propagação para evitar fechar logo após abrir
      dropdownMenu.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
      if (!dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.remove("show");
      }
    });
  });