const eyes =document.getElementById('togglePassword');
const password =document.getElementById('password');
eyes.addEventListener('click', function(){
    const type =password.getAttribute('type') === 'password' ?'text' :'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.style.marginTop = '5px';
    this.classList.toggle('fa-eye-slash');// gạch chéo của icon
});