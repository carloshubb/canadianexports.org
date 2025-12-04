<script src="{{ asset('plugins/swiper/swiper-bundle.min.js') }}"></script>
<script>
    const btn = document.querySelector("button.mobile-menu-button");
    const menu = document.querySelector(".mobile-menu");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
</script>
<script>
    // exporters swiper 
    var swiper = new Swiper(".exporters-slider", {
        grabCursor: true,
        loop: true,
        spaceBetween: 30,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            1200: {
                slidesPerView: 3,
            },
            1920: {
                slidesPerView: 4,
            },
        }
    });



    // magazine swiper 
    var swiper = new Swiper(".magazine-slider", {
        grabCursor: true,
        loop: true,
        spaceBetween: 30,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
            1920: {
                slidesPerView: 5,
            },
        }
    });
</script>
