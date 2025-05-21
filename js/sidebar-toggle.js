// Hamburger and Sidebar Toggle Script
// Place this before </body> in your HTML or in a JS file included on all pages with the sidebar

document.addEventListener('DOMContentLoaded', function() {
  const hamburger = document.querySelector('.hamburger');
  const sidebar = document.querySelector('.sidebar');

  if (hamburger && sidebar) {
    hamburger.addEventListener('click', function(e) {
      e.stopPropagation();
      hamburger.classList.toggle('active');
      sidebar.classList.toggle('open');
      document.body.classList.toggle('sidebar-open');
    });
  }

  // Also close sidebar if overlay is clicked
  const overlay = document.querySelector('.sidebar-overlay');
  if (overlay) {
    overlay.addEventListener('click', function() {
      sidebar.classList.remove('open');
      hamburger.classList.remove('active');
      document.body.classList.remove('sidebar-open');
    });
  }

  // Close sidebar on click outside (for mobile)
  document.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !hamburger.contains(e.target) && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      hamburger.classList.remove('active');
      document.body.classList.remove('sidebar-open');
    }
  });

  // Responsive: auto-close sidebar on resize if width < 900px
  window.addEventListener('resize', function() {
    if (window.innerWidth < 900) {
      sidebar.classList.remove('open');
      hamburger.classList.remove('active');
      document.body.classList.remove('sidebar-open');
    }
  });

  // On load, ensure sidebar is closed on small screens
  if (window.innerWidth < 900) {
    sidebar.classList.remove('open');
    hamburger.classList.remove('active');
    document.body.classList.remove('sidebar-open');
  }
});
