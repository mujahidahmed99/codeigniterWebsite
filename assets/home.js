var add_transaction = document.getElementById('addTransaction');
var transaction_overlay = document.getElementById('transactionOverlay');
var category_overlay = document.getElementById('categoryOverlay');
var close_transaction = document.getElementById('cancelTransaction');
var category_btn = document.getElementById('categoryInput');
var close_category = document.getElementById('closeCategoryOverlay');
var transaction_form = document.getElementById('filterTransactions');
var hamburger_menu = document.getElementById('navMenu');
var menu_overlay = document.getElementById('overlay');
var close_menu_overlay = document.getElementById('closeOverlay');
var item_overlay = document.getElementById('itemOverlay');
var close_item_overlay = document.getElementById('closeItemOverlay');
const months = document.querySelectorAll('[data-month-content]');
var date = new Date();
add_transaction.addEventListener('click', ()=>{
    transaction_overlay.classList.add('active');
});

close_transaction.addEventListener('click', ()=>{
    transaction_overlay.classList.remove('active');
});

category_btn.addEventListener('click', ()=>{
    category_overlay.classList.add('active');
});

close_category.addEventListener('click', ()=>{
    category_overlay.classList.remove('active');
});

hamburger_menu.addEventListener('click', ()=>{
    menu_overlay.classList.add('active');
});

close_menu_overlay.addEventListener('click', ()=>{
    menu_overlay.classList.remove('active');
});

close_item_overlay.addEventListener('click', ()=>{
    item_overlay.classList.remove('active');
})
function createElementWithClass(elementName, className) {
    
    var el = document.createElement(elementName);
    el.className = className;

    return el;
};

function monthName(mon) {
    return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'][mon - 1];
};

months.forEach(month => {
    month.removeAttribute("selected");
    if(month.value == date.getMonth() + 1){
        month.setAttribute('selected',"");
    }
});

$('#jsCategoryItems').on("change", "li", function (event) {
    console.log($(this).val());
})

$('#filterTransactions').on('change', function() {
    var node = document.getElementById('jsTransactions');
    node.textContent = '';
    var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};

        that.find('[name]').each(function( index, value){
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
            data[name] = value;
        });
        var month_name = monthName(data['month']);
    $('#month').text(month_name);
    $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: "json",
        success: function(response) {
            console.log(response);
            if(response.fail) {
                console.log(response.message);
            }
            if(response.success){
                if(response.data === false){
                    console.log("TRUE");
                    var transaction_history = createElementWithClass('div', 'transaction-history'),
                    message = createElementWithClass('H4', 'transaction-message');
                    transaction_history.appendChild(message);
                    message.innerHTML = "No Transactions Found!";
                    document.getElementById("jsTransactions").appendChild(transaction_history);
                }else{
                    jQuery.each(response.data, function(index, value){
                        console.log(value);
                        var transaction_history = createElementWithClass('div', 'transaction-history'),
                        transaction_details = createElementWithClass('ul', 'transaction-details'),
                        item_name = createElementWithClass('li', 'item-name'),
                        item_name_tag = createElementWithClass('a', 'item-name-tag'),
                        item_price = createElementWithClass('li', 'item-price'),
                        item_date = createElementWithClass('li', 'item-date'),
                        item_location = createElementWithClass('li', 'item-location'),
                        del_tag = createElementWithClass('a', 'delete-transaction'),
                        del_icon = createElementWithClass('i', 'fas fa-trash-alt');

                        transaction_history.appendChild(transaction_details);
                        transaction_details.appendChild(item_name);
                        item_name.appendChild(item_name_tag);
                        transaction_details.appendChild(item_price);
                        transaction_details.appendChild(item_date);
                        transaction_details.appendChild(item_location);
                        transaction_history.appendChild(del_tag);
                        item_name_tag.textContent = value.cat_name;
                        item_price.innerHTML = value.amount;
                        item_date.innerHTML = value.date;
                        item_location.innerHTML = value.location;
                        item_name_tag.setAttribute("href", "http://localhost/expense_tracker/pages/request_item_transaction/" + value.transaction_id);
                        del_tag.setAttribute("href", "http://localhost/expense_tracker/pages/delete_transaction_by_id/" + value.transaction_id);
                        del_tag.appendChild(del_icon);
                        transaction_history.appendChild(del_tag);
                        document.getElementById("jsTransactions").appendChild(transaction_history);
                    });
                }
                $('#inflowValue').text(response.inflow);
                $('#outflowValue').text(response.outflow);
                $('#totalValue').text(response.total);
            }
            
        }
    });
    return false;
});

$('a.category-header').on('click', function() {
    var node = document.getElementById('jsCategoryItems');
    node.textContent = '';
    var that = $(this),
    url = that.attr('href');
    $.ajax({
        url: url,
        dataType: "json",
        success: function(response){
            if(response.fail) {
                console.log(response.message);
            }
            if(response.success){
                var category_list = createElementWithClass('ul', 'category-list');
                jQuery.each(response.data, function(index, value){
                    
                    var category_items = createElementWithClass('li', 'category-items');

                    category_list.appendChild(category_items);
                    category_items.id = value.id;
                    category_items.innerHTML = value.cat_name;
                    document.getElementById("jsCategoryItems").appendChild(category_list);
                });
            };
        }
    });
    return false;
});

$(document).on('click', '.category-items', function () {
    var that = $(this),
        value = that.text(),
        id = that.attr('id');
    console.log(id);
    category_btn.value = value;
    category_overlay.classList.remove('active');
});

$('form.ajax').on('submit', function() {
    var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};

        that.find('[name]').each(function( index, value){
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
            data[name] = value;
        });
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if(response.fail) {
                    if(response.wallet != ''){
                        $('#walletError').html(response.wallet);
                        $('#walletInput').addClass("is-invalid");
                    }
                    else{
                        $('#walletError').html('');
                        $('#walletInput').removeClass("is-invalid");
                    }
                    if(response.category != ''){
                        $('#categoryError').html(response.category);
                        $('#categoryInput').addClass("is-invalid");
                    }
                    else{
                        $('#categoryError').html('');
                        $('#categoryInput').removeClass("is-invalid");
                    }
                    if(response.amount != ''){
                        $('#amountError').html(response.amount);
                        $('#amountInput').addClass("is-invalid");
                    }
                    else{
                        $('#amountError').html('');
                        $('#amountInput').removeClass("is-invalid");
                    }
                    if(response.date != ''){
                        $('#dateError').html(response.date);
                        $('#dateInput').addClass("is-invalid");
                    }
                    if(response.location != ''){
                        $('#locationError').html(response.location);
                        $('#lcationInput').addClass("is-invalid");
                    }
                    else{
                        $('#dateError').html('');
                        $('#dateInput').removeClass("is-invalid");
                    }
                }
                if(response.success){
                    $('#walletError').html('');
                    $('#walletInput').removeClass("is-invalid");
                    $('#categoryError').html('');
                    $('#categoryInput').removeClass("is-invalid");
                    $('#amountError').html('');
                    $('#amountInput').removeClass("is-invalid");
                    $('#dateError').html('');
                    $('#dateInput').removeClass("is-invalid");
                    console.log(response.success);
                }

                if(response.db_fail){
                    console.log(response.message);
                }
            }
       });
    return false;
});

$(document).on('click', 'a.delete-transaction', function(){
    var that = $(this),
    url = that.attr('href');
    console.log(url);
    $.ajax({
        url: url,
        dataType: "json",
        success: function(response){
            if(response.success) {
                
                console.log(response.id);
            }
        }
    })
    var event = new Event ('change');
    transaction_form.dispatchEvent(event);
    return false;
});

$(document).on('click', '.item-name-tag', function(){
    var that = $(this),
        url = that.attr('href');
        console.log(url);
    $.ajax({
        url: url,
        dataType: "json",
        success: function(response){
            var name = document.getElementById('transactionItemName'),
                amount = document.getElementById('transactionItemPrice'),
                date = document.getElementById('transactionItemDate'),
                type = document.getElementById('transactionItemType'),
                notes = document.getElementById('notesDisplay');
                
            jQuery.each(response.data, function(index, value){
                if(value.inflow == 1){
                    value.inflow = 'Inflow';
                } else{
                    value.inflow = 'Outflow';
                }
                console.log(value.cate_name);
                console.log(value.amount);
                console.log(value.date);
                console.log(value.inflow);
                name.innerHTML = value.cat_name;
                amount.innerHTML = value.amount;
                date.innerHTML = value.date;
                type.innerHTML = value.inflow;
                notes.text = value.notes;
            });            
        }
    });
    item_overlay.classList.add('active')
    return false;
});

$('#flexSwitchCheckDefault').on('click', function(){
    $.ajax({
        url: "https://geolocation-db.com/jsonp",
        jsonpCallback: "callback",
        dataType: "jsonp",
        success: function(location) {
          $('#locationInput').val(location.city);
        }
      });
})