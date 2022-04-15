function slide(slider){
    const nextBtn = slider.querySelector(".next-btn");
    const prevBtn = slider.querySelector(".prev-btn");
    const slides = slider.querySelectorAll(".slide");
    const slideIcons = slider.querySelectorAll(".slide-icon");
    const numberOfSlides = slides.length;
    var slideNumber = 0;

    nextBtn.addEventListener("click", () => {
        slides.forEach((slide) => {
            slide.classList.remove("active");
        });
        slideIcons.forEach((slideIcon) => {
            slideIcon.classList.remove("active");
        });

        slideNumber++;

        if(slideNumber > (numberOfSlides - 1)){
            slideNumber = 0;
        }

        slides[slideNumber].classList.add("active");
        slideIcons[slideNumber].classList.add("active");
        });

        prevBtn.addEventListener("click", () => {
        slides.forEach((slide) => {
            slide.classList.remove("active");
        });
        slideIcons.forEach((slideIcon) => {
            slideIcon.classList.remove("active");
        });

        slideNumber--;

        if(slideNumber < 0){
            slideNumber = numberOfSlides - 1;
        }

        slides[slideNumber].classList.add("active");
        slideIcons[slideNumber].classList.add("active");
    });

    var playSlider;

    var repeater = () => {
        playSlider = setInterval(function(){
            slides.forEach((slide) => {
                slide.classList.remove("active");
            });
            slideIcons.forEach((slideIcon) => {
                slideIcon.classList.remove("active");
            });

            slideNumber++;

            if(slideNumber > (numberOfSlides - 1)){
                slideNumber = 0;
            }

            slides[slideNumber].classList.add("active");
            slideIcons[slideNumber].classList.add("active");
        }, 5000);
    }
    repeater();

    slider.addEventListener("mouseover", () => {
        clearInterval(playSlider);
    });

    slider.addEventListener("mouseout", () => {
        repeater();
    });
}

slide(document.getElementById("sliderImage"));
slide(document.getElementById("sliderVideo"));
