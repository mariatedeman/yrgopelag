// SHOW ROOM INFO
const select = document.getElementById('show-room-info');
const selectRoomBooking = document.getElementById('room_type');
const budgetElements = document.querySelectorAll('.budget')
const standardElements = document.querySelectorAll('.standard')
const luxuryElements = document.querySelectorAll('.luxury')
const hiddenRoomInput = document.getElementById('hidden-room-id');

// INCLUDED IN OFFER
const offer = document.getElementById('offer');
const offerRoom = document.getElementById('room_type');
const offerFeature = document.getElementById('feature-4');

// TRANSFER CODE FORM
const showTransfercodeForm = document.getElementById('show-transfercode-form');
const getTransfercodeForm = document.getElementById('transfercode-form');



// === SHOW HEADER ON SCROLL ===
scrollFunction();
window.addEventListener ('scroll', scrollFunction);

function scrollFunction() {
    const header = document.getElementById('header');

    if (!header) return;
    
    const totalPageHeight = document.documentElement.scrollHeight;
    const viewportHeight = window.innerHeight;
    
    // SHOW HEADER RIGHT AWAY ON SMALL PAGES 
    if (totalPageHeight <= viewportHeight) {
        header.style.top = "0"
        header.style.position = "sticky";
    } else {
        const scrollAmount = window.scrollY || document.documentElement.scrollTop;
        
        if (header) {
            if (scrollAmount > 20) {
            header.style.top = "0";
        } else {
            header.style.top = "-100px";
        }
    }
}
}


// === OPEN AND CLOSE MENU === //
function openNav() {
    document.getElementById("nav").style.width = "25%";
}

function closeNav() {
    document.getElementById("nav").style.width = "0%";    
}

window.addEventListener('click', function(event) {
    const nav = document.getElementById('nav');
    const openBtn = document.querySelector('.menu-icon');
    const navLinks = document.querySelectorAll('nav a');

    // CLOSE MENU ON LINK CLICK
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeNav();
        })
    })

    // CLOSE MENU ON CLICK OUTSIDE
    if (nav.style.width === "25%" && !nav.contains(event.target) && event.target !== openBtn) {
        closeNav();
    }

})


// === SHOW SUB MENU === //
function openSubMenu() {
    const content = document.querySelector('.subnav-content');

    content.classList.toggle('open');
}


// === ROOM PRESENTATION ===
function showRoomInfo(event) {
    if (!select || !selectRoomBooking) return;
    
    // UPDATE ROOM PRESENTATION WHEN CHOOSING ROOM IN BOOKING
    if (event && event.target === selectRoomBooking) {
        select.value = selectRoomBooking.value;
    }

    const selectValue = select.value;

    if (hiddenRoomInput) {
        hiddenRoomInput.value = select.value;
    }

    if (selectValue == 1) {
        budgetElements.forEach(element => {
            element.style.display = 'flex';
        });

        standardElements.forEach(element => {
            element.style.display = 'none';
        })

        luxuryElements.forEach(element => {
            element.style.display = 'none';
        })
    }

    if (selectValue == 2) {
        budgetElements.forEach(element => {
            element.style.display = 'none';
        });

        standardElements.forEach(element => {
            element.style.display = 'flex';
        })

        luxuryElements.forEach(element => {
            element.style.display = 'none';
        })
    }

    if (selectValue == 3) {
        budgetElements.forEach(element => {
            element.style.display = 'none';
        });

        standardElements.forEach(element => {
            element.style.display = 'none';
        })

        luxuryElements.forEach(element => {
            element.style.display = 'flex';
        })
    }
}


// === SHOW IMGS AND CALENDAR FOR CHOSEN ROOM === 
if (select) {
    select.addEventListener ('change', showRoomInfo);
}

if (selectRoomBooking) {
    selectRoomBooking.addEventListener ('change', showRoomInfo);
}

showRoomInfo();

// === IMG SLIDESHOW === //
let slideIndex = 1;
showSlides(slideIndex);

    // NEXT / PREV
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName('slides');
        let dots = document.getElementsByClassName('dot');

        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slides[slideIndex - 1].style.display = "block";
    }
    
    
// === SHOW FORM TO FETCH TRANSFER CODE ===
if (showTransfercodeForm) {
    showTransfercodeForm.addEventListener ('click', function (event) {
        showTransfercodeForm.style.display = 'none';
        getTransfercodeForm.style.display = 'flex';       
    })
}


// === COPY TEXT ===
function copytext(id) {
    const element = document.getElementById(id);
    const button = document.querySelector('.copy-text');
    let textCopy = "";

    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
        element.select();
        textCopy = element.value;
    } else {
        textCopy = element.textContent;
    }

    navigator.clipboard.writeText(textCopy).then(() => {
        button.style.background = '#6d726b';
        button.textContent = 'Copied!';
    })
}



// === BEGINNING OF YEAR OFFER CHECKBOX ===
if (offer) {
    offer.addEventListener ('change', function (event) {
        if (offer.checked) {
            offerFeature.checked = true;
            offerRoom.value = 3;
        } else if (!offer.checked) {
            offerFeature.checked = false;
            offerRoom.value = '';
        }
    })
}


// === DISPLAY TOTAL COST === //
const bookingForm = document.getElementById('booking-form');
const totalCostDisplay = document.getElementById('total_cost');

const calculateTotal = () => {
    let total = 0;

    // FETCH ROOM PRICE
    const roomSelect = document.getElementById('room_type');
    const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
    const roomPrice = selectedRoom.dataset.price ? Number(selectedRoom.dataset.price) : 0;

    // CALCULATE NUMBER OF NIGHTS
    const arrival = new Date(document.getElementById('checkIn').value);
    const departure = new Date(document.getElementById('checkOut').value);
        
    let nights = 0;

    if (arrival && departure && departure > arrival) {
        const diffTime = Math.abs(departure - arrival);
        nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }

    total += (roomPrice * nights);

    // FETCH CHECKED FEATURES
    const checkedFeautures = document.querySelectorAll('.feature-checkbox:checked');
    checkedFeautures.forEach(feature => {
        
        const featurePrice = Number(feature.dataset.price);
        total += featurePrice;

        if (roomSelect.value === '3' && feature.value === '4') {
            total -= featurePrice;
        }
    })

    totalCostDisplay.textContent = total;

};

bookingForm.addEventListener('change', calculateTotal);