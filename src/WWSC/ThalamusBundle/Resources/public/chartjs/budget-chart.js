var month_names = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

var plannedHours = [];
var actualHours = [];
var labels = [];
$.each(budgetData['year'], function( date, obj ) {
    actualHours.push(obj.remaining);
    plannedHours.push(obj.plan);
    var aDate = date.split('-');
    if(aDate.length == 2) {
        var dataStr = aDate[1]+'/'+ aDate[0];
        var oDate = new Date(dataStr);
        var month = oDate.getMonth();
        if ($.inArray(month , month_names)) {
            labels.push(month_names[month]);
        }
    }
});

var color = Chart.helpers.color;
var config = {
    type: 'bar',
    title: {
        display: true,
        text: 'Stunden verbraucht (aktueller Monat)'
    },
    data: {
        labels: labels,
        datasets: [
            {
                type: 'line',
                label: 'Plan',
                backgroundColor: '#7079CC',
                borderColor: '#7079CC',
                pointBackgroundColor:'#ffffff',
                pointBorderColor:'#7079CC',
                pointBorderWidth: 2,
                pointRadius:5,
                borderColor:'#7079CC',
                fill: false,
                data: plannedHours,
            },{
                type: 'bar',
                label: 'Actual',
                backgroundColor: "#56CCFC",
                borderColor: "#56CCFC",
                data: actualHours,
            }]
    }
};

window.onload = function() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);

};