<html lang="en">
<body>
<nav class="navbar grid">
        <a href="#" id="navMenu"><i class="fas fa-bars fa-2x"></i></a>
        <h1>Expense Tracker</h1>
    </nav>

    <section id="filter" class="grid">
        <div class="select-filter">
            <form action="<?php echo base_url();?>pages/filter_chart" method="post" id="selectFormChart">
                <div class="form-floating">
                    <select class="form-select" name="year" id="reportYearSelect">
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                    </select>
                    <label for="yearSelect">Select Year</label>
                </div>
                <div class="form-floating">
                    <select class="form-select" name="month" id="reportMonthSelect">
                        <option value="01" data-monthchart-content>January</option>
                        <option value="02" data-monthchart-content>February</option>
                        <option value="03" data-monthchart-content>March</option>
                        <option value="04" data-monthchart-content>April</option>
                        <option value="05" data-monthchart-content>May</option>
                        <option value="06" data-monthchart-content>June</option>
                        <option value="07" data-monthchart-content>July</option>
                        <option value="08" data-monthchart-content>August</option>
                        <option value="09" data-monthchart-content>September</option>
                        <option value="10" data-monthchart-content>October</option>
                        <option value="11" data-monthchart-content>November</option>
                        <option value="12" data-monthchart-content>December</option>
                    </select>
                    <label for="monthSelect">Select Month</label>
                </div>
            </form>
        </div>
    </section>
    <section id="graph" class="grid">
        <div class="graph-container">
            <h3 id="graphEmpty">No Data Found</h3>
            <canvas id="myChart"></canvas>
        </div>
    </section>
</body>
<script src="<?php echo base_url();?>/assets/report.js" async></script>
</html>