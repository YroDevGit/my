import Ctr, { Ctrx } from "../code/src/mods/ctr";
import { Twal } from "../code/src/mods/twal";
import { Tyrax } from "../code/src/tyrux/main";
import { inquiryTypes } from "./_models/inquiry_type";
import TModal from "../code/src/mods/modals/tmodal";

const itypes = await inquiryTypes();

const track = document.getElementById('teamScrollTrack');
const members = track.querySelectorAll('.team-member');
const memberWidth = members[0].offsetWidth;
let currentIndex = 0;
let interval;

function scrollToIndex(index) {
  const maxIndex = members.length - 4; // Show 4 at a time
  if (index > maxIndex) {
    // Loop back to start
    currentIndex = 0;
    track.style.transition = 'none';
    track.style.transform = `translateX(0)`;
    // Force reflow
    void track.offsetHeight;
    track.style.transition = 'transform 0.5s ease';
  } else {
    currentIndex = index;
    track.style.transform = `translateX(-${index * memberWidth}px)`;
  }
}

function nextSlide() {
  const maxIndex = members.length - 4;
  if (currentIndex >= maxIndex) {
    // Reset to start
    scrollToIndex(0);
  } else {
    scrollToIndex(currentIndex + 1);
  }
}

// Start autoplay (move every 2 seconds)
function startAutoplay() {
  interval = setInterval(nextSlide, 2000);
}

// Stop autoplay on hover
track.addEventListener('mouseenter', function () {
  clearInterval(interval);
});

track.addEventListener('mouseleave', function () {
  startAutoplay();
});

// Start the carousel
startAutoplay();

// Handle window resize
window.addEventListener('resize', function () {
  // Recalculate member width
  const newWidth = members[0].offsetWidth;
  // Update position
  track.style.transition = 'none';
  track.style.transform = `translateX(-${currentIndex * newWidth}px)`;
  void track.offsetHeight;
  track.style.transition = 'transform 0.5s ease';
});
//Js file for landing
(function () {
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

  let tmodal = TModal.init({
    title: "<i class='fas fa-envelope me-2'></i>Email us",
    id: "modex",
    form_id: "emailus",
    form: {
      email: { type: "text", label: "<i class='fas fa-at'></i> Enter your email:" },
      type: { tag: "select", label: "<i class='fas fa-code'></i> Type:", options: itypes, config: { value: "id", label: "type" }, index: "SELECT INQUIRY TYPE" },
      message: { tag: "textarea", label: "<i class='fas fa-message'></i> Message" },
    }
  });

  Ctrx.click("#titlebelow", () => {
    Ctrx.redirect("user/login");
  });

  Ctrx.click(".email-modal", () => {
    tmodal.show();
    tmodal.form_submit((data, raw) => {
      Tyrax.post({
        url: "user/inquire",
        data: raw,
        loading: { id: "emailus", size: 40 },
        res: (send, code, message, data, errors) => {
          if (code == 400) {
            Twal.err(message);
            tmodal.displayErrors(errors);
            return;
          }
          if (code == 200) {
            Twal.ok("Your message has been sent", true);
          }
        }
      })
    });

  })
})();