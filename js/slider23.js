const slideBox = document.querySelector('.aside-photo1');
const slideBox2 = document.querySelector('.aside-photo2');

const photos = ['/img/aside1--img0.jpg', '/img/aside1--img1'];
const photos2 = [
  '/img/aside2--img0.jpg',
  '/img/aside2--img1.jpg',
];

let i = 0;
let j=0
function changePhoto(photoArray) {
  slideBox.src = `../img/aside1--img${i}.jpg`;
  slideBox2.src = `../img/aside2--img${i}.jpg`;
  i++;
  if (i==photoArray.length)i=0;
  

}
function changePhoto2(photoArray) {
  slideBox.src = `../img/aside1--img${j}.jpg`;
  slideBox2.src = `../img/aside2--img${j}.jpg`;
  j++;
  if (j==photoArray.length)j=0;
  

}
setInterval('changePhoto(photos)', 3000);
setInterval('changePhoto2(photos2)', 3000);