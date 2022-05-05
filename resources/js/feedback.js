const feedBackElement = document.querySelector('#feedback');
const starsContainer = feedBackElement.querySelector('.stars');
const starInput = feedBackElement.querySelector('input[type="number"]');
let clickedStar = false;

starsContainer.addEventListener('mouseleave', () => {
    if (!clickedStar && !starInput.value) {
        const stars = Array.from(starsContainer.children);
        for (let i = 0; i < stars.length; i++) {
            let src = 'http://192.168.100.80:8000/images/star-outline.svg';
            stars[i].setAttribute('src', src);
        }
    }
});
feedBackElement.addEventListener('mouseover', starMouseOver);
feedBackElement.addEventListener('click', starClick);

function starMouseOver(event) {
    if (!clickedStar && !starInput.value) {
        setStar(event);
    }
}

function starClick(event) {
    setStar(event);
}

function setStar(event) {
    if (event.target.nodeName == 'IMG') {
        Array.from(event.target.parentElement.children).forEach((element, index) => {
            if (element == event.target) {
                const stars = Array.from(starsContainer.children);

                if (starsContainer.classList.contains('has-error')) {
                    starsContainer.classList.remove('has-error');
                }

                for (let i = 0; i < stars.length; i++) {
                    let src = '';
                    if (i < index + 1) {
                        src = 'http://192.168.100.80:8000/images/star-solid.svg';
                    } else {
                        src = 'http://192.168.100.80:8000/images/star-outline.svg';
                    }
                    stars[i].setAttribute('src', src);
                }

                if (event.type == 'click') {
                    clickedStar = true;
                    starInput.value = index + 1;
                    const starErrorContainer = feedBackElement.querySelector('.star-error');
                    if (starErrorContainer) {
                        starErrorContainer.style.display = 'none';
                    }
                }
            }
        });
    }
}