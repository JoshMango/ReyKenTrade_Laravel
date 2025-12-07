@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">
<style>
    .home-wrap {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    .intro-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .intro-text h1 {
        font-size: 3em;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .intro-text h3 {
        font-size: 1.5em;
        margin-bottom: 30px;
        opacity: 0.9;
    }
    .browse-button {
        padding: 15px 15px 35px 15px;
        background: white;
        color: #667eea;
        border: none;
        border-radius: 8px;
        font-size: 1.2em;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .browse-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .recommendations {
        margin-top: 40px;
    }
    .bestsellers-wrap h1 {
        color: #333;
        margin-bottom: 30px;
        font-size: 2.5em;
        text-align: center;
    }
    #bestsellers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
    .bestseller-item {
    background: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
    }

    .img-wrapper {
        width: 100%;
        height: 200px;
        border-radius: 12px; /* Apply rounding here */
        overflow: hidden; /* IMPORTANT: Clips zoomed image */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transform: scale(1.55);
        transform-origin: center;
    }
    .bestseller-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .bestseller-item h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.2em;
    }
    .bestseller-item p {
        color: #5344ff;
        font-size: 1.5em;
        font-weight: bold;
        margin-top: 10px;
    }
    .intro-carousel {
    position: relative;
    height: 350px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    margin-bottom: 40px;
    padding: 60px 40px;
    color: white;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Slides container */
.carousel-slide {
    position: absolute;
    width: 100%;
    top: 50%;
    left: 100%;
    transform: translateY(-50%);
    opacity: 0;
    transition: all 0.7s ease-in-out;
    text-align: center;
}

/* Active slide */
.carousel-slide.active {
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 1;
}

/* Sliding left */
.carousel-slide.slide-left {
    left: -100%;
}

/* Sliding right */
.carousel-slide.slide-right {
    left: 200%;
}

/* Titles */
.carousel-slide h1 {
    font-size: 3em;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.carousel-slide h3 {
    font-size: 1.5em;
    opacity: 0.9;
    margin-bottom: 30px;
}

/* Arrows */
.carousel-arrow {
    position: absolute;
    top: 50%;
    font-size: 2.5em;
    font-weight: bold;
    color: white;
    cursor: pointer;
    padding: 10px 15px;
    border-radius: 50%;
    background: rgba(53, 57, 135, 0.2);
    transform: translateY(-50%);
    transition: 0.3s;
}

.carousel-arrow:hover {
    background: rgba(18, 0, 108, 0.35);
}

.carousel-arrow.left {
    left: 15px;
}

.carousel-arrow.right {
    right: 15px;
}

/* Mobile - smaller header */
@media (max-width: 480px) {
    .intro-carousel {
        height: 300px;
        padding: 40px 20px;
    }
    .carousel-slide h1 {
        font-size: 2em;
    }
    .carousel-slide h3 {
        font-size: 1.2em;
    }
    .carousel-arrow {
        font-size: 2em;
    }
}

</style>

<div class="home-wrap">
    <div class="intro-carousel">
        <div class="carousel-slide active">
            <h1>Browse our finest selection of tires</h1>
            <h3>Premium quality tires for every vehicle and driving style</h3>
            <button class="browse-button">Browse Collection</button>
        </div>

        <div class="carousel-slide">
            <h1>Exceptional durability for rough terrains</h1>
            <h3>Engineered to perform in all Philippine road conditions</h3>
            <button class="browse-button">Shop Now</button>
        </div>

        <div class="carousel-slide">
            <h1>Trusted by thousands of drivers</h1>
            <h3>Your safety and comfort are our top priorities</h3>
            <button class="browse-button">Discover More</button>
        </div>

        <!-- Arrows -->
        <div class="carousel-arrow left">&#10094;</div>
        <div class="carousel-arrow right">&#10095;</div>

    </div>
    
    <div class="recommendations">
        <div class="bestsellers-wrap">
            <h1>Bestsellers</h1>
            <div id="bestsellers-grid">
                @forelse($bestsellers as $product)
                    <div class="bestseller-item" onclick="window.location.href='{{ route('products.show', $product->product_id) }}'">
                        <div class="img-wrapper">
                            <img src="{{ asset('storage/uploads/' . $product->productImage) }}" alt="{{ $product->productName }}"/>
                        </div>
                        <h3>{{ $product->productName }}</h3>
                        @if($product->brand)
                            <p style="font-size: 0.9em; color: #666; margin: 5px 0;">{{ $product->brand }}</p>
                        @endif
                        <p>₱{{ number_format($product->productPrice, 2) }}</p>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                        <p>No bestsellers found yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const totalSlides = slides.length;
let autoSlide;

function showSlide(index, direction = 'right') {
    slides.forEach((slide, i) => {
        slide.classList.remove('active', 'slide-left', 'slide-right');
        slide.style.opacity = 0;

        if (i === index) {
            slide.classList.add('active');
            slide.style.opacity = 1;
        } else {
            slide.classList.add(direction === 'right' ? 'slide-left' : 'slide-right');
        }
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide, 'right');
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide, 'left');
}

/* Arrow Controls */
document.querySelector('.carousel-arrow.right').addEventListener('click', () => {
    nextSlide();
    resetAutoSlide();
});

document.querySelector('.carousel-arrow.left').addEventListener('click', () => {
    prevSlide();
    resetAutoSlide();
});

/* Auto Slide */
function startAutoSlide() {
    autoSlide = setInterval(nextSlide, 5000);
}

function resetAutoSlide() {
    clearInterval(autoSlide);
    startAutoSlide();
}

startAutoSlide();

/* Swipe Gesture Support */
let touchStartX = 0;

document.querySelector('.intro-carousel').addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
});

document.querySelector('.intro-carousel').addEventListener('touchend', (e) => {
    let touchEndX = e.changedTouches[0].screenX;

    if (touchEndX < touchStartX - 50) {
        nextSlide();
        resetAutoSlide();
    }
    if (touchEndX > touchStartX + 50) {
        prevSlide();
        resetAutoSlide();
    }
});
</script>
@endsection
