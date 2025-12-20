const select = document.getElementById('show-room-info');
const calenderRoomOne = document.querySelector('.room-one');
const calenderRoomTwo = document.querySelector('.room-two');
const calenderRoomThree = document.querySelector('.room-three');

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
}
)