function hideSideNavigation() {
  document.getElementById("nav").classList.remove('active');
}

function showSideNavigation() {
  document.getElementById("nav").classList.add('active');
}

export { hideSideNavigation, showSideNavigation };
