let title = document.getElementById('title');
let stars = document.getElementById('stars');
let mountains_front = document.getElementById('mountains_front');
let btn = document.getElementById('btn');
let header = document.querySelector('header');
window.addEventListener('scroll', function() {
    var value = window.scrollY;
    title.style.top = -value * -2.05 + 'px';
    stars.style.left = value * 0.25 + 'px';
    header.style.top =-value * -0.5 + 'px';
    mountains_front.style.top =-value * 0 + 'px';
});
ScrollReveal({
    reset: false,
    distance: '60px',
    duration: 2500,
    opacity: 0
  });
ScrollReveal().reveal('h2 img', { delay: 100, origin: 'top' });
ScrollReveal().reveal('.img1, .text2', { delay: 100, origin: 'left' });
ScrollReveal().reveal('.text1, .img2', { delay: 100, origin: 'right' });
ScrollReveal().reveal('.slider,.info,.info .part,.nous,.nous .part div', {distance: '200px',interval: 200, delay: 100, origin: 'bottom' });
ScrollReveal().reveal('.info p',{distance:'0px',delay:2000});