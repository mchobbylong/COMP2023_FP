var cake_type = cake_size = 0;
var giftcard = false;
var topping = new Array();
var message = '';

function update_cake_type(v){
    cake_type = v;
    getCheck();
}

function update_cake_size(v){
    cake_size = v;
    getCheck();
}

function update_topping(){
    var arr = document.getElementsByName('topping[]');
    topping = [];
    for (var i = 0; i < arr.length; ++i)
        if (arr[i].checked) topping.push(arr[i].value);
    getCheck();
}

function update_giftcard(v){
    giftcard = v;
    getCheck();
}

function update_message(v){
    message = v;
    getCheck();
}

function get_cake_type(){
	if (cake_type == 0) return '';
	var arr = new Array('Mango Mousse', 'Passion Mousse', 'Sweet Wine', 'Durian Crazy', 'Rum Cheese', 'Black & White', 'Teatime', 'Chestnum Cream');
	return arr[cake_type - 1];
}

function get_cake_size(){
    if (cake_size == 0) return '';
    var arr = new Array('Small', 'Medium', 'Large');
    return arr[cake_size - 1];
}

function get_topping(){
    if (topping.length == 0) return '';
    var arr = new Array('Chocolate', 'Cheese cream', 'Oreo biscuit', 'Strawberry');
    var text = arr[topping[0] - 1];
    for (var i = 1; i < topping.length; ++i)
        text += ', ' + arr[topping[i] - 1];
    return text;
}

function get_giftcard(){
    if (giftcard) return 'Yes';
    return 'No';
}

function get_price(){
	if (cake_type == 0 || cake_size == 0) return '';
    var arr = new Array(0, 185, 240, 210, 260, 200, 220, 220, 235);
    var price = arr[cake_type];
    var arr = new Array(0, 25, 40, 30, 45);
    for (var i = 0; i < topping.length; ++i)
        price += arr[topping[i]];
    price = price * (0.5 * cake_size + 0.5);
    return price.toFixed(1);
}

function getCheck(){
    document.getElementById('check_cake_type').innerHTML =  get_cake_type();
    document.getElementById('check_cake_size').innerHTML = get_cake_size();
    document.getElementById('check_topping').innerHTML = get_topping();
    document.getElementById('check_giftcard').innerHTML = get_giftcard();
	document.getElementById('check_message').innerHTML = message;
	var price = get_price();
	document.getElementById('check_price').innerHTML = '¥' + price;
	document.getElementById('cost').value = price;
}

function verify_form(){
	return (cake_type > 0 && cake_size > 0);
}