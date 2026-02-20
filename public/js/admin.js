document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".sidebar");
    if (!btn || !sidebar) return;
  
    btn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
    });
  });
  