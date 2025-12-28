// SHOW ROOM INFO
const select = document.getElementById('show-room-info');
const budgetElements = document.querySelectorAll('.budget')
const standardElements = document.querySelectorAll('.standard')
const luxuryElements = document.querySelectorAll('.luxury')
const hiddenRoomInput = document.getElementById('hidden-room-id');

// INCLUDED IN OFFER
const offer = document.getElementById('offer');
const offerRoom = document.getElementById('room_type');
const offerFeature = document.getElementById('seafood cruise with live music');

// TRANSFER CODE FORM
const showTransfercodeForm = document.getElementById('show-transfercode-form');
const getTransfercodeForm = document.getElementById('transfercode-form');

// SHOW HEADER ON SCROLL
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

function showRoomInfo() {
    if (!select) return;

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
    showRoomInfo();
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

// === SHOW FORM TO FETCH TRANSFER CODE ===
if (showTransfercodeForm) {
    showTransfercodeForm.addEventListener ('click', function (event) {
        showTransfercodeForm.style.display = 'none';
        getTransfercodeForm.style.display = 'flex';       
    })
}

// === COPY TRANSFER CODE ===
function copytext() {
    const copyText = document.getElementById('transfercode');
    const button = document.querySelector('.copy-text');

    copyText.select();
    navigator.clipboard.writeText(copyText.value);

    button.style.background = '#6d726b';
    button.textContent = 'Copied!';
}

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