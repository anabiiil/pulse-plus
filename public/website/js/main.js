


  new Swiper('.mySwiper', {
    loop: true,
    speed: 900,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });


window.addEventListener("load", () => {
  const loader = document.getElementById("loader");
  setTimeout(() => {
    loader.classList.add("opacity-0", "pointer-events-none");
  }, 700);
  setTimeout(() => {
    loader.remove();
  }, 1200);
});


const animatedItems = Array.from(document.querySelectorAll(
  '.swiper, section, footer, nav, .shadow-lg, .shadow-xl'
)).filter(el => !el.closest('#burgerMenu'));

animatedItems.forEach(el => {
  el.style.opacity = '0';
  el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
});

function animate(el) {
  el.style.opacity = '1';
}

const observer = new IntersectionObserver(
  (entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animate(entry.target);
        obs.unobserve(entry.target);
      }
    });
  },
  {
    threshold: 0.15,
    rootMargin: '0px 0px -50px 0px', 
  }
);

animatedItems.forEach(el => {
  observer.observe(el);

  const rect = el.getBoundingClientRect();
  if (rect.top < window.innerHeight) {
    animate(el);
    observer.unobserve(el);
  }
});


const btn = document.getElementById('menu-btn');
const box = document.getElementById('burgerMenu');

btn.addEventListener('click', () => {
  box.classList.toggle('flex!');
});