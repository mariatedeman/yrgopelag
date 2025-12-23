const select = document.getElementById('show-room-info');
const budgetElements = document.querySelectorAll('.budget')
const standardElements = document.querySelectorAll('.standard')
const luxuryElements = document.querySelectorAll('.luxury')

const offer = document.getElementById('offer');
const offerRoom = document.getElementById('room_type');
const offerFeature = document.getElementById('seafood cruise with live music');

const showTransfercodeForm = document.getElementById('show-transfercode-form');
const getTransfercodeForm = document.getElementById('transfercode-form');


// === SHOW IMGS AND CALENDAR FOR CHOSEN ROOM === 
select.addEventListener ('change', function(event) {
    const selectValue = select.value;

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
});

// === BEGINNING OF YEAR OFFER CHECKBOX ===
offer.addEventListener ('change', function (event) {
    if (offer.checked) {
        offerFeature.checked = true;
        offerRoom.value = 3;
    } else if (!offer.checked) {
        offerFeature.checked = false;
        offerRoom.value = '';
    }
})

// === SHOW FORM TO FETCH TRANSFER CODE ===
showTransfercodeForm.addEventListener ('click', function (event) {
    getTransfercodeForm.style.display = 'flex';
    showTransfercodeForm.style.display = 'none';

})

// === COPY TRANSFER CODE ===
function copytext() {
    const copyText = document.getElementById('transfercode');
    const button = document.querySelector('.copy-text');

    copyText.select();
    navigator.clipboard.writeText(copyText.value);

    button.style.background = '#6d726b';
    button.textContent = 'Copied!';
}


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

        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className = " active";
    }