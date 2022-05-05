import axios from "axios";
import flatpickr from "flatpickr";
import moment from 'moment';

const petContainer = document.querySelector('.pet');
const petContainerSelect = petContainer.querySelector('select');

petContainerSelect.addEventListener('change', getPetProfile);

getPetProfile();

function getPetProfile() {
    axios.get('/pets/profile', {
        params: {
            id: petContainerSelect.value
        }
    })
        .then(response => {
            while (petContainer.children.length > 1) {
                petContainer.lastElementChild.remove();
            }

            const imageDiv = document.createElement('div');
            let petProfile = response.data.profile;
            petProfile = petProfile.replace('public', 'storage');
            console.log(petProfile)
            imageDiv.style.backgroundImage = `url('/${petProfile}')`;
            imageDiv.classList.add('image');
            petContainer.appendChild(imageDiv);
        })
        .catch(error => {
            console.log(error)
        });
}

//? -------------------------------------------------------------------------
//? DATE SELECTOR
//? -------------------------------------------------------------------------

let datepicker = document.querySelector('#date');
let datepickerValue = null;
let timepicker = document.querySelector('#time');
let tommorow = moment().add(1, 'd').toDate();
let maxDate = moment().add(60, 'd').toDate();
let availableTimes = [];
let takenTimes = [];

axios.get('/reservations/times', {})
    .then(response => {
        availableTimes = response.data;

        if (datepicker.value.length > 0) {
            datepickerValue = datepicker.value;
            datepickerChange();
        }
    })
    .catch(error => console.log(error));

axios.get('/reservations/between', {
    params: {
        min: tommorow,
        max: maxDate,
    }
})
    .then(response => {
        let counts = {};
        let dbTimes = response.data;
        let excludeDates = [];

        dbTimes.forEach(function (x) { counts[x] = (counts[x] || 0) + 1; });
        for (var key in counts) {
            if (counts[key] == availableTimes.length) {
                excludeDates.push(key);
            }
        }

        if (datepickerValue != null) {
            flatpickr(datepicker, {
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                minDate: tommorow,
                maxDate: maxDate,
                disable: excludeDates,
                defaultDate: datepickerValue
            });
        } else {
            flatpickr(datepicker, {
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                minDate: tommorow,
                maxDate: maxDate,
                disable: excludeDates,
            });
        }

        datepicker.addEventListener('change', datepickerChange);
    })
    .catch(error => console.log(error));



function datepickerChange() {
    removeAllChildElement(timepicker);
    takenTimes = [];

    axios.get('/reservations/taken', {
        params: {
            date: datepicker.value,
        }
    })
        .then(response => {
            response.data.forEach(reservation => {
                takenTimes.push(reservation.time);
            });

            let difference = availableTimes.filter(x => !takenTimes.includes(x));
            difference.forEach(time => {
                addChildToElement(timepicker, 'option', time);
            });
        })
        .catch(error => console.log(error));
}

function removeAllChildElement(node) {
    while (node.lastElementChild) {
        node.removeChild(node.lastElementChild);
    }
}

function addChildToElement(parent, childElementType, childElementValue) {
    const element = document.createElement(childElementType);
    element.setAttribute('value', childElementValue);
    element.innerText = childElementValue;

    parent.appendChild(element);
}