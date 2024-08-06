<div class="bg-shape bg-shape1 bg-yellow opacity-50 bg-blur"></div>
<div class="bg-shape bg-shape2 bg-primary opacity-50 bg-blur"></div>
<div class="bg-shape bg-shape3 bg-red opacity-50 bg-blur"></div>
<div class="bg-shape bg-shape1 bg-primary opacity-50 bg-blur"></div>
<div class="bg-shape bg-shape2 bg-yellow opacity-50 bg-blur"></div>
<div class="bg-shape bg-shape3 bg-red opacity-50 bg-blur"></div>


<script>
function getRandomPosition(element) {
    const windowHeight = window.innerHeight;
    const windowWidth = window.innerWidth;
    const randomTop = Math.floor(Math.random() * (windowHeight - element.clientHeight));
    const randomLeft = Math.floor(Math.random() * (windowWidth - element.clientWidth));
    return { top: randomTop, left: randomLeft };
}

document.addEventListener("DOMContentLoaded", function() {
    const shapes = document.querySelectorAll('.bg-shape');

    shapes.forEach(shape => {
        const { top, left } = getRandomPosition(shape);
        shape.style.top = `${top}px`;
        shape.style.left = `${left}px`;
    });
});

</script>
