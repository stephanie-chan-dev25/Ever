const defaultMenuIcon = document.querySelector(".menu-icon-default");
const activeMenuIcon = document.querySelector(".menu-icon-active");
const nav = document.querySelector("nav");
const menu = document.querySelector("nav ul");
const MOBILE_BREAKPOINT = 800;

if (defaultMenuIcon && activeMenuIcon && nav && menu) {
  const closeMenu = () => nav.classList.remove("menu-open");

  const toggleMenu = () => {
    if (window.innerWidth <= MOBILE_BREAKPOINT) {
      nav.classList.toggle("menu-open");
    }
  };

  defaultMenuIcon.addEventListener("click", toggleMenu);
  activeMenuIcon.addEventListener("click", toggleMenu);

  menu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      if (window.innerWidth <= MOBILE_BREAKPOINT) {
        closeMenu();
      }
    });
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > MOBILE_BREAKPOINT) {
      closeMenu();
    }
  });
}

