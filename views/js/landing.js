//Js file for landing
(function() {
    // simple console greeting – no external libraries
    console.log('🚀 CodeYro – custom web apps & hosting.');
    // optional: smooth anchor scroll (lightweight)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  })();