console.log("javascript is running");

const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const closebar = document.getElementById('closebar');

if(bar){
    bar.addEventListener('click', () => {
        console.log("navbar is clicked");
        nav.classList.toggle('active');
    })
}

if(closebar){
    closebar.addEventListener('click', () => {
        nav.classList.remove('active');
    })
}
document.getElementById('fileUpload').addEventListener('change', function(){
    const fileName = this.files[0] ? this.files[0].name : 'No file selected';
    document.getElementById('fileName').textContent = fileName;
  });
  