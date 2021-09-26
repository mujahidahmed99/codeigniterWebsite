var cancel_btn = document.getElementById("cancelWallet");
var add_wallet = document.getElementById("addWallet");
var wallet_overlay = document.getElementById("walletOverlay");
var wallet_action = document.getElementById("walletAction");
var wallet_cncel = document.getElementById("cancelWalletDel");
var hamburger_menu = document.getElementById('navMenu');
var menu_overlay = document.getElementById('overlay');
var close_menu_overlay = document.getElementById('closeOverlay');

hamburger_menu.addEventListener('click', ()=>{
    menu_overlay.classList.add('active');
});

close_menu_overlay.addEventListener('click', ()=>{
    menu_overlay.classList.remove('active');
});
cancelWalletDel.addEventListener('click', () => {
    wallet_action.classList.remove('active');
});



add_wallet.addEventListener('click', ()=>{
    wallet_overlay.classList.add('active');
});
cancel_btn.addEventListener('click', () => {
    wallet_overlay.classList.remove('active');
});

$('form.ajax').on('submit', function() {
    var that = $(this),
    url = that.attr('action'),
    type = that.attr('method'),
    data = {};
    that.find('[name]').each(function(index, value) {
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
            if(response.error){
                if(response.cardname_exists != ''){
                    $('#cardname_error').html(response.cardname_exists);
                }
                else{
                    $('#cardname_error').html('');
                }
                if(response.cardname != ''){
                    $('#cardname_error').html(response.cardname);
                }
                else{
                    $('#cardname_error').html('');
                }
                if(response.balance != ''){
                    $('#balance_error').html(response.balance);
                }
                else{
                    $('#balance_error').html('');
                }
            }
            
            if(response.success){
                document.getElementById('msgAlert').classList.add('active');
                $('#cardname_error').html('');
                $('#balance_error').html('');
            }
        }
    });
    return false;
});

$('a.ajax').on('click', function() {
    var that = $(this),
    url = that.attr('href');
    $.ajax({
        url: url,
        dataType: "json",
        success: function(response) {
            if(response.success){
                console.log(response);
                jQuery.each(response.data, function(index, value){
                    wallet_action.classList.add('active');
                    $('#dynWalletName').html(value.wallet_name);
                    $('#dynWalletBal').html(value.balance);
                })
            }
        }
    });
    return false;
});
