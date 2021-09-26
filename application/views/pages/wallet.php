<html lang="en">
<body>
    
    <div id ="walletAction" class="overlay grid">
        <div class="wallet-container">
            <div class="wallet-header-action">
                <h4>Wallet Information</h4>
            </div>
            <ul class="wallet-info">
                <li id="dynWalletName"></li>
                <li id="dynWalletBal"></li>
            </ul>
            <ul class="wallet-create">
                <li><button class="wallet-btn" id="cancelWalletDel" type="submit">Cancel</button></li>
                <li><button class="wallet-btn" id="delWallet" type="button">Delete</button></li>
            </ul>
        </div>
    </div>

    <div id="walletOverlay" class="overlay grid">
        <div class="wallet-container">
            <div class="wallet-header-creator">
                <h4>Add Card</h4>
            </div>
            <form  method="post" action="<?php echo base_url();?>pages/add_card" class="ajax">
                <ul>
                    <li>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="cardname">
                            <label for="floatingInput">Card Name</label>
                            <span id="cardname_error" class="text-danger"></span>
                        </div>
                    </li>
                    <li>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="balance">
                            <label for="floatingInput">Initial Balance</label>
                            <span id="balance_error" class="text-danger"></span>
                        </div>
                    </li>
                </ul>
                <ul class="wallet-create">
                    <li><button class="wallet-btn" id="createWallet" type="submit">Add</button></li>
                    <li><button class="wallet-btn" id="cancelWallet" type="button">cancel</button></li>
                </ul>
            </form>
            <span id="msgAlert">Success</span>
         </div>
    </div>
    <nav class="navbar grid">
        <a href="#" id="navMenu"><i class="fas fa-bars fa-2x"></i></a>
        <h1>Expense Tracker</h1>
        <button id="addWallet" class="button-nav">Add Wallet</button>
    </nav>

    <section id="wallet" class="grid">
        <div class="wallet-header">
            <span class="wallet-name">Cards</span>
        </div>
        <?php foreach(array_reverse($cards) as $card) {?>
        <?php if($card['active_wallet'] == 0){ ?>
        <div class="wallet-item">
            <a href="<?php echo base_url();?>pages/request_card/<?php echo $card['id'];?>" id="<?php echo $card['id'] ?>" class="ajax"><span><?php echo $card['wallet_name']; ?></span></a>
            
        </div>
        <?php }else{ ?>
        <div class="wallet-last-item">
            <a href="<?php echo base_url();?>pages/request_card/<?php echo $card['id'];?>" id = "<?php echo $card['id'] ?>" class="ajax"><p><?php echo $card['wallet_name']; ?></p></a>
            <span>active</span>
        </div>
        <?php } ?> 
        <?php }; ?>
    </section>
</body>
<script src="<?php echo base_url();?>/assets/wallet.js" async></script>
</html>