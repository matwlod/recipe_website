const slideBox = document.querySelector('.aside-photo1');
const slideBox2 = document.querySelector('.aside-photo2');

const photos = ['/img/aside1--img0.jpg', '/img/aside1--img1.jpg'];
const photos2 = ['/img/aside2--img0.jpg', '/img/aside2--img1.jpg'];

let i = 0;
let j = 0;

function changePhoto(photoArray, slideBox) {
  i++;
  if (i === photoArray.length) i = 0;

  
  setTimeout(() => {
    slideBox.src = photoArray[i];
    slideBox.style.opacity = 1;
  }, 1000);
}

function changePhoto2(photoArray, slideBox) {
  j++;
  if (j === photoArray.length) j = 0;

  
  setTimeout(() => {
    slideBox.src = photoArray[j];
    slideBox.style.opacity = 1;
  }, 1000);
}

setInterval(() => changePhoto(photos, slideBox), 4000);
setInterval(() => changePhoto2(photos2, slideBox2), 4000);
