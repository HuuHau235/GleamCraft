
const increase_so_luong = document.getElementById("increase");
const limit_so_luong=  document.getElementById("reduce");
const quantity =document.getElementById('quantity');
increase_so_luong.addEventListener('click',function(){
    let current_quantity = parseInt(quantity.value);
    quantity.value = current_quantity + 1;
});
limit_so_luong.addEventListener('click',function(){
    let current_quantity = parseInt(quantity.value);
    if (current_quantity >1){
        quantity.value = current_quantity - 1;
    }
});

