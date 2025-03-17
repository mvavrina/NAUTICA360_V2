import './bootstrap';
import 'flowbite';

import Swiper from 'swiper/bundle';  // Import everything
import 'swiper/css/bundle';  // Import all styles

import { MarkerClusterer } from "@googlemaps/markerclusterer";

async function initMap() {
  // Request needed libraries.
  const { Map, InfoWindow } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
    "marker",
  );
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 3,
    center: { lat: -28.024, lng: 140.887 },
    mapId: "DEMO_MAP_ID",
  });
  const infoWindow = new google.maps.InfoWindow({
    content: "",
    disableAutoPan: true,
  });
  // Create an array of alphabetical characters used to label the markers.
  const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  // Add some markers to the map.
  const markers = locations.map((position, i) => {
    const label = labels[i % labels.length];
    const pinGlyph = new google.maps.marker.PinElement({
      glyph: label,
      glyphColor: "white",
    });
    const marker = new google.maps.marker.AdvancedMarkerElement({
      position,
      content: pinGlyph.element,
    });

    // markers can only be keyboard focusable when they have click listeners
    // open info window when marker is clicked
    marker.addListener("click", () => {
      infoWindow.setContent(position.lat + ", " + position.lng);
      infoWindow.open(map, marker);
    });
    return marker;
  });

  // Add a marker clusterer to manage the markers.
  new MarkerClusterer({ markers, map });
}


const swiper = new Swiper('.blog-swiper', {
    loop: true,
    slidesPerView: 1,  // Default to 1 slide per view
    spaceBetween: 46,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      // When the viewport is >= 768px (Medium screens)
      768: {
        slidesPerView: 2,  // Show 2 slides per view
      },
      // When the viewport is >= 1024px (Large screens)
      1024: {
        slidesPerView: 3,  // Show 3 slides per view
      },
    },
  });
  

var refs = new Swiper('.swiper-container', {
    slidesPerView: 1,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    spaceBetween: 10,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
      // When the viewport is >= 768px (Medium screens)
      1024: {
        slidesPerView: 2,  // Show 2 slides per view
      },
    },
});

const swiperYachts = new Swiper('.swiper-yachts', {
  slidesPerView: 1,        // Show one slide at a time
  spaceBetween: 10,        // Space between slides (optional)
  navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
  },
  pagination: {
      el: '.swiper-pagination',
      clickable: true,      // Enable dot navigation
  },
  loop: true,              // Enable loop
});

const yachtdetail = new Swiper(".yacht-detail-swiper", {
  spaceBetween: 0,
  slidesPerView: 1, // Allows dynamic width per slide
  centeredSlides: true, // Keeps the active slide centered
  loop: true,
  autoplay: {
      delay: 3000,
      disableOnInteraction: false,
  },
  navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
  },
  pagination: {
      el: ".swiper-pagination",
      clickable: true,
  },
});