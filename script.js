document.getElementById("loginForm").addEventListener("submit", function (event) {
  event.preventDefault();

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  // Exemplo simples de validação
  if (username === "admin" && password === "1234") {
    alert("Login bem-sucedido!");
    // Redirecionar ou continuar no sistema
    window.location.href = "dashboard.html"; // exemplo
  } else {
    document.getElementById("error-message").textContent = "Usuário ou senha incorretos.";
  }
});
