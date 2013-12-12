function showHideDiv(div1, div2){
    var x = document.getElementById(div1);
    var y = document.getElementById(div2);

    if(x.style.display == 'none'){
        x.style.display = 'block';
        y.style.display = 'none';
    } else {
        x.style.display = 'none';
         y.style.display = 'block';
    }

    return false;
}