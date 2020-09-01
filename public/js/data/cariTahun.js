var min = 2019,
    max = new Date().getFullYear(),
    select = document.getElementById('dateYear');

for (var i = min; i <= max; i++) {
    var opt = document.createElement('option');
    opt.value = i;
    opt.innerHTML = i;
    select.appendChild(opt);

}
