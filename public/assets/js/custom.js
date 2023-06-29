new Chart(document.getElementById("sales_chart"), {
    type: "bar",
    data: {
        labels: xData,
        datasets: [
            {
                label: "Sales of last ten days",
                data: yData,
                backgroundColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});

new Chart(document.getElementById("sales_summery_chart"), {
    type: "pie",
    data: {
        labels: ["Achived", "Need to achive"],
        datasets: [
            {
                data: [thisMonth, lastMonth],
                backgroundColor: [
                    "rgba(46, 125, 50, 1)",
                    "rgba(255, 179, 0, 1)",
                ],
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});
