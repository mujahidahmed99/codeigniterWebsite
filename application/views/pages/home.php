<html lang="en">

<body>
    <div id="transactionOverlay" class="overlay grid">
        <div class="create-transaction">
            <div class="create-header">
                <h3>Add Transaction</h3>
            </div>
            <form action="<?php echo base_url();?>pages/add_transaction" method="post" class="ajax" id="addTransactionForm">
                <ul class="form-items grid">
                    <li>
                        <div class="form-floating" id="walletGridItem">
                            <input type="button" class="form-control" name="wallet" id="walletInput" value="savings">
                            <label for="walletInput">Select a Wallet</label>
                            <span class="text-danger" id="walletError" data-validation-error></span>
                        </div>
                    </li>
                    <li>
                        <div class="form-floating" id="categoryGridItem">
                            <input type="button" class="form-control" name="category" id="categoryInput">
                            <label for="walletInput">Select a Category</label>
                            <span class="text-danger" id="categoryError" data-validation-error></span>
                        </div>
                    </li>
                    <li>
                        <div class="form-floating" id="amountGridItem">
                            <input type="text" class="form-control" name="amount" id="amountInput">
                            <label for="amountInput">Amount</label>
                            <span class="text-danger" id="amountError" data-validation-error></span>
                        </div>
                    </li>
                    <li>
                        <div class="form-floating" id="dateGridItem">
                            <input type="date" class="form-control" name="date" id="dateInput">
                            <label for="dateInput">Date</label>
                            <span class="text-danger" id="dateError" data-validation-error></span>
                        </div>
                    </li>
                    <li>
                        <div class="form-floating" id="locationGridItem">
                            <input type="text" class="form-control" name="location" id="locationInput">
                            <label for="locationInput">Location</label>
                            <span class="text-danger" id="locationError" data-validation-error></span>
                        </div>
                    </li>
                    <li>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label form-switch-label" for="flexSwitchCheckDefault">Use Current Location</label>
                    </div>
                    </li>
                    <li id="transactionNotes">
                        <div class="form-floating" id="NotesGridItem">
                            <input type="text" class="form-control" name="notes" id="notesInput">
                            <label for="notesInput">Notes</label>
                        </div>
                    </li>
                    <li>
                        <button class="button" id="createTransaction" type="submit">Add</button>
                    </li>
                    <li><button id="cancelTransaction" class="button" type="button">Cancel</button></li>
                </ul>
            </form>
        </div>
    </div>

    <div id="categoryOverlay" class="grid">
        <div class="category-container">
            <div class="create-header">
                <h3>Add Category</h3>
                <button id="closeCategoryOverlay" class="close-overlay">&times;</button>
            </div>
            <ul class="category-header grid">
                <li class="category-border"><a class="category-header" href="<?php echo base_url();?>pages/filter_category/debt">Debt/Loan</a></li>
                <li class="category-border"><a class="category-header" href="<?php echo base_url();?>pages/filter_category/expense">Expense</a></li>
                <li class="category-border"><a class="category-header" href="<?php echo base_url();?>pages/filter_category/income">Income</a></li>
                <li id="categoryListItem">
                    <div class="category-list-container">
                        <input class="form-control" type="search" placeholder="search" id="searchCat">
                        <div id="jsCategoryItems">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <nav class="navbar grid">
        <a href="#" id="navMenu"><i class="fas fa-bars fa-2x"></i></a>
        <h1>Expense Tracker</h1>
        <button id="addTransaction" class="button-nav">Add Transaction</button>
    </nav>

    <section id="filter" class="grid">
        <div class="select-filter">
            <form action="<?php echo base_url();?>pages/filter_transaction" method="post" id="filterTransactions">
                <div class="form-floating">
                    <select class="form-select" name="year" id="yearSelect">
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                    </select>
                    <label for="yearSelect">Select Year</label>
                </div>
                <div class="form-floating">
                    <select class="form-select" name="month" id="monthSelect">
                        <option value="01" data-month-content>January</option>
                        <option value="02" data-month-content>February</option>
                        <option value="03" data-month-content>March</option>
                        <option value="04" data-month-content>April</option>
                        <option value="05" data-month-content>May</option>
                        <option value="06" data-month-content>June</option>
                        <option value="07" data-month-content>July</option>
                        <option value="08" data-month-content>August</option>
                        <option value="09" data-month-content>September</option>
                        <option value="10" data-month-content>October</option>
                        <option value="11" data-month-content>November</option>
                        <option value="12" data-month-content>December</option>
                    </select>
                    <label for="monthSelect">Select Month</label>
                </div>
            </form>
        </div>
    </section>
    <section id="netSpend" class="grid">
        <div class="transaction-content">
            <ul class="net-labels">
                <li>Inflow</li>
                <li>Outflow</li>
                <li>Total</li>
            </ul>
            <ul class="net-values">
                <li id="inflowValue"><?php echo $inflow_total;?></li>
                <li id="outflowValue"><?php echo $outflow_total;?></li>
                <li id="totalValue"><?php echo ($inflow_total-$outflow_total);?></li>
            </ul>
        </div>
    </section>
    <section id="transactions" class="grid">
        <div class="transaction-header">
            <h2 id="month"><?php echo date('F')?></h2>
        </div>
        <div id="jsTransactions">
            <?php if(!empty($transactions)) {?>
                <?php foreach($transactions as $transaction) {?>
                    <div class="transaction-history">
                        <ul class="transaction-details">
                            <li class="item-name"><a class="item-name-tag" href="<?php echo base_url();?>pages/request_item_transaction/<?php echo $transaction['transaction_id']?>"><?php echo $transaction['cat_name']; ?></a></li>
                            <li class="item-price"><?php echo $transaction['amount']; ?></li>
                            <li class="item-date"><?php echo $transaction['date']; ?></li>
                            <li class="item-location"><?php echo $transaction['location']; ?></li>
                        </ul>
                        <a href="<?php echo base_url();?>pages/delete_transaction_by_id/<?php echo $transaction['transaction_id']?>"><i class="fas fa-trash-alt"></i></a>
                    </div>
                <?php };?>
            <?php }else{?>
                <div class="transaction-history">
                    <h4>No Transactions Found!</h4>
                </div>
            <?php };?>            
        </div>
        <div id="itemOverlay" class="overlay">
        <button id="closeItemOverlay" class="close-item-overlay">&times;</button>
            <div class="overlay-container">
                <h3 class="overlay-header">Transaction Information</h3>
                <ul class="overlay-labels">
                    <li>Category:</li>
                    <li>Spent:</li>
                    <li>Date:</li>
                    <li>Type:</li>
                </ul>
                <ul class="overlay-values">
                    <li id="transactionItemName"></li>
                    <li id="transactionItemPrice"></li>
                    <li id="transactionItemDate"></li>
                    <li id="transactionItemType"></li>
                </ul>
                <textarea name="" id="notesDisplay" cols="30" rows="10" readonly></textarea>
            </div>
        </div>
    </section>
    <section id="footer">
        <div class="footer"></div>
    </section>
</body>
<script src="<?php echo base_url();?>/assets/home.js" async></script>
</html>