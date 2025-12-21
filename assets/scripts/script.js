const select = document.getElementById('show-room-info');
const calenderRoomOne = document.querySelector('.room-one');
const calenderRoomTwo = document.querySelector('.room-two');
const calenderRoomThree = document.querySelector('.room-three');
const offer = document.getElementById('offer');
const offerRoom = document.getElementById('room_type');
const offerFeature = document.getElementById('seafood cruise with live music');

// SHOW IMGS AND CALENDAR FOR CHOSEN ROOM
select.addEventListener ('change', function(event) {
    const selectValue = select.value;

    if (selectValue == 1) {
        calenderRoomOne.style.display = 'block';
        calenderRoomTwo.style.display = 'none';
        calenderRoomThree.style.display = 'none';
    }

    if (selectValue == 2) {
        calenderRoomOne.style.display = 'none';
        calenderRoomTwo.style.display = 'block';
        calenderRoomThree.style.display = 'none';
    }

    if (selectValue == 3) {
        calenderRoomOne.style.display = 'none';
        calenderRoomTwo.style.display = 'none';
        calenderRoomThree.style.display = 'block';
    }
});

// BEGINNING OF YEAR OFFER
offer.addEventListener ('change', function (event) {
    if (offer.checked) {
        offerFeature.checked = true;
        offerRoom.value = 3;
    } else if (!offer.checked) {
        offerFeature.checked = false;
        offerRoom.value = '';
    }
})