const labels = ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6"];

const day = [
    { x: Date.parse("2022-10-18 "), y: 15 },
    { x: Date.parse("2022-10-19 "), y: 10 },
    { x: Date.parse("2022-10-20 "), y: 20 },
    { x: Date.parse("2022-10-21 "), y: 30 },
    { x: Date.parse("2022-10-22 "), y: 40 },
    { x: Date.parse("2022-10-23 "), y: 5 },
    { x: Date.parse("2022-10-24 "), y: 15 },
    { x: Date.parse("2022-10-25 "), y: 20 }
];

const data = {
    // labels: labels,
    datasets: [
        {
            backgroundColor: "rgb(255, 99, 132)",
            borderColor: "rgb(255, 99, 132)",
            color: "#fff",
            // data: [0, 10, 5, 2, 20, 30, 45]
            data: []
        }
    ]
};

const config = {
    type: "line",
    data: data,
    options: {
        interaction: {
            intersect: false,
            mode: "index"
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(context) {
                        return (
                            "Tháng " +
                            context.label +
                            ": " +
                            context.dataset.data[context.parsed.x] +
                            "tr"
                        );
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: "white",
                    font: {
                        size: 14
                    }
                },
                offset: true,
                display: true,
                title: {
                    display: true,
                    text: "(Tháng)",
                    color: "#191",
                    font: {
                        family: "Times",
                        size: 20,
                        style: "normal",
                        lineHeight: 1.2
                    },
                    padding: { top: 30, left: 0, right: 0, bottom: 0 }
                }
            },
            y: {
                ticks: {
                    color: "white",
                    font: {
                        size: 14
                    },
                    stepSize: 10,
                    beginAtZero: true
                },
                min: 0,
                max: 50,
                title: {
                    display: true,
                    text: "(1tr)",
                    color: "#191",
                    font: {
                        family: "Times",
                        size: 20,
                        style: "normal",
                        lineHeight: 1.2
                    },
                    padding: { top: 0, left: 0 }
                }
            }
        }
    }
};

const myChart = new Chart(document.getElementById("myChart"), config);

$(document).ready(function() {
    getSatistic();

    $("#filterSatistic").click(function() {
        getSatistic();
    });
});

function getSatistic() {
    const startMonth = $("#startMonth").val();
    const endMonth = $("#endMonth").val();
    const _token = $('input[name="_token"]').val();
    var data = [];
    if (startMonth && endMonth) {
        $.ajax({
            url: "/statistic",
            method: "post",
            dataType: "json",
            data: {
                startMonth: startMonth,
                endMonth: endMonth,
                _token: _token
            },
            async: false,
            success: function(res) {
                data = JSON.parse(JSON.stringify(res));
                let newData = [];
                let labels = [];
                data.forEach(element => {
                    labels.push(element.month);
                    newData.push(element.total / 1000000); // format to 1tr
                });
                myChart.data.datasets[0].data = newData;
                myChart.data.labels = labels;
                myChart.update();
            }
        });
    } else {
        swal({
            title: "OPP",
            text: "Nhập khoảng thời gian thống kê",
            icon: "warning",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK"
        });
    }
    return data;
}
