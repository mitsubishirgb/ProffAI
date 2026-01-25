function load_component(component_path) {
    const component_name = component_path.split("/").pop().replace(".html", "");

    fetch(component_path)  
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        document.getElementById(component_name + '-placeholder').innerHTML = data;
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector('.slider'); 
    const slides = document.querySelectorAll('.slider .slide');
    
    if (!slider || slides.length === 0) return;

    let currentIndex = 0;
    const intervalTime = 4500; 
    let slideInterval; 

    function showSlide(index) {
        slides.forEach((slide) => {
            slide.classList.remove('active');
        });
        slides[index].classList.add('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }

    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, intervalTime);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // Pause kur bejm hover
    slider.addEventListener('mouseenter', stopAutoSlide); 
    
    // Resume kur heket mausi
    slider.addEventListener('mouseleave', startAutoSlide); 

    // Initializimi
    showSlide(currentIndex);
    startAutoSlide();
});

