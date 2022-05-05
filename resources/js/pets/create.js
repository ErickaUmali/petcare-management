import axios from "axios";
import flatpickr from "flatpickr";
import moment from 'moment';

const birthdayPicker = document.querySelector('#birthday');
let birthdayPickerValue = null;
const minDate = moment().subtract(20, 'years').toDate();
const maxDate = moment().subtract(14, 'days').toDate();
const speciesPicker = document.querySelector('#species');
const breedPicker = document.querySelector('#breed');

flatpickr(birthdayPicker, {
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    minDate: minDate,
    maxDate: maxDate,
    defaultDate: birthdayPickerValue
});

speciesPicker.addEventListener('change', () => {
    axios.get('/pets/breeds', {
        params: {
            species_id: speciesPicker.value,
        }
    })
        .then(response => {
            const breeds = response.data;
            breedPicker.innerHTML = '';

            let breedPickerInnerHtml = '';

            breeds.forEach(breed => {
                breedPickerInnerHtml += `<option value="${breed.id}">${breed.name}</option>`;
            });

            breedPicker.innerHTML = breedPickerInnerHtml;
        })
        .catch(error => {
            console.log(error);
        });
});