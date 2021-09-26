let myChart = document.getElementById('myChart').getContext('2d');
var canvas = document.getElementById('myChart');
var no_data_msg = document.getElementById('graphEmpty');
const months_chart = document.querySelectorAll('[data-monthchart-content]');
var d = new Date();
var hamburger_menu = document.getElementById('navMenu');
var menu_overlay = document.getElementById('overlay');
var close_menu_overlay = document.getElementById('closeOverlay');

hamburger_menu.addEventListener('click', ()=>{
    menu_overlay.classList.add('active');
});

close_menu_overlay.addEventListener('click', ()=>{
    menu_overlay.classList.remove('active');
});

months_chart.forEach(month => {
    month.removeAttribute("selected");
    if(month.value == d.getMonth() + 1){
        month.setAttribute('selected',"");
    }
});


var barChart = new Chart(myChart, {
    type:'bar',
    data:{
        datasets:[{
            backgroundColor:[
                'rgba(42, 111, 174, 0.6)',
                'rgba(228, 146, 18, 0.6)',
                'rgba(115, 120, 196, 0.6)',
                'rgba(144, 209, 199, 0.6)',
                'rgba(89, 152, 228, 0.6)',
                'rgba(223, 229, 68, 0.6)',
                'rgba(15, 235, 159, 0.6)',
                'rgba(159, 72, 145, 0.6)'
            ] 
        }]
        
    },
    options:{}
});

$.ajax({
    url: "http://localhost/expense_tracker/pages/get_chart_data/7/2021",
    dataType: "json",
    success: function(response) {
        barChart.clear();
        var arr_cat = [];
        var arr_vals = [];
        console.log(response);
        if(response != null){
            no_data_msg.classList.remove('active');
            canvas.classList.add('active');
            for (i = 0; i < response.length; i++){
                arr_cat.push(response[i].cat_name);
                arr_vals.push(response[i].amount);
            };
            var categories = arr_cat;
            barChart.data.datasets[0].label = 'Categories';
            barChart.data.labels = categories;
            barChart.data.datasets[0].data = arr_vals;
            barChart.update();
        }else{
            canvas.classList.remove('active');
            no_data_msg.classList.add('active');
        }
    }
});

function monthName(mon){
    return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'][mon - 1];
};

$('#selectFormChart').on('change', function() {
    barChart.clear();
    console.log('click');
    var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};

    that.find('[name]').each(function(index, value){
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
            var arr_cat = [];
            var arr_vals = [];
            console.log(response);
            if(response != null){
                no_data_msg.classList.remove('active');
                canvas.classList.add('active');
                for (i = 0; i < response.length; i++){
                    arr_cat.push(response[i].cat_name);
                    arr_vals.push(response[i].amount);
                };
                var categories = arr_cat;
                barChart.label = 'Categories';
                barChart.data.labels = categories;
                barChart.data.datasets[0].label = 'Categories';
                barChart.data.datasets[0].data = arr_vals;
                barChart.update();
            }else{
                canvas.classList.remove('active');
                no_data_msg.classList.add('active');
            }
        }
    })

})