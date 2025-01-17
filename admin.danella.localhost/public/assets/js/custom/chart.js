const serviceCanvas = document.getElementById('serviceCanvas');
const achievementCanvas = document.getElementById('achievementCanvas');
const fileManagerCanvas = document.getElementById('fileManagerCanvas');
const projectPerMonthYearSelect = document.getElementById('projectPerMonthYear');

var styleChart = getComputedStyle(document.body);
var primaryColorChart = styleChart.getPropertyValue('--primary-color');
var firstColorChart = styleChart.getPropertyValue('--chart-first-color');
var secondColorChart = styleChart.getPropertyValue('--chart-second-color');
var fontFamilyChart = styleChart.getPropertyValue('--chart-font-family');

var servicePerProjectJsonChart = JSON.parse(serviceCanvas.dataset.servicePerProject);
var servicePerBlogJsonChart = JSON.parse(serviceCanvas.dataset.servicePerBlog);

var serviceNameJson = JSON.parse(serviceCanvas.dataset.serviceName);
var serviceLabelsChart = [];
Object.values(serviceNameJson).forEach((value) => {
    serviceLabelsChart.push(value.name.split(' '));
});

// Set font family for all chart
Chart.defaults.font.family = fontFamilyChart;

var projectPerMonthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];


projectPerMonthYearSelect.addEventListener('change', function () {
    var projectPerMonthAjaxUrl = 'dashboard?project_per_month_year=' + this.value;
    var blogPerMonthAjaxUrl = 'dashboard?blog_per_month_year=' + this.value;

    removeData(projectPerMonthChart);
    projectPerMonthAjax(function (output) {
        projectPerMonthChart.data.datasets.push(projectPerMonthObject(JSON.parse(output)));
        projectPerMonthChart.update();
    }, projectPerMonthAjaxUrl);
    projectPerMonthAjax(function (output) {
        projectPerMonthChart.data.datasets.push(blogPerMonthObject(JSON.parse(output)));
        projectPerMonthChart.update();
    }, blogPerMonthAjaxUrl);

});


var projectPerMonthChart = new Chart(achievementCanvas, {
    type: 'line',
    data: {
        labels: projectPerMonthLabels,
        datasets: [
            projectPerMonthObject(JSON.parse(achievementCanvas.dataset.projectPerMonth)),
            blogPerMonthObject(JSON.parse(achievementCanvas.dataset.blogPerMonth)),
        ]
    },

});


new Chart(serviceCanvas, {
    type: 'bar',
    data: {
        labels: serviceLabelsChart,
        datasets: [
            {
                label: 'Projects',
                data: servicePerProjectJsonChart,
                backgroundColor: [primaryColorChart],
            },
            {
                label: 'Blogs',
                data: servicePerBlogJsonChart,
                backgroundColor: [secondColorChart],
            },
        ]
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    title: function (context) {
                        let label = '';
                        Object.entries(context).forEach((entry) => {
                            const [key, value] = entry;
                            label = value.label.replace(",", " ");
                        });

                        return label;
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true
            },
        },
    }
});


new Chart(fileManagerCanvas, {
    type: 'doughnut',
    data: {
        labels: ['Used Space', 'Total Space', 'Free Space'],
        datasets: [{
            label: '',
            data: [
                fileManagerCanvas.dataset.fileUsedSpace,
                fileManagerCanvas.dataset.fileTotalSpace,
                fileManagerCanvas.dataset.fileFreeSpace,
            ],
            backgroundColor: [
                firstColorChart,
                primaryColorChart,
                secondColorChart
            ],
            hoverOffset: 4
        }],
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context) {
                        return bytesToSize(context.raw);
                    }
                }
            }
        },
        elements: {
            arc: {
                borderWidth: 0
            }
        }
    }
});

function removeData(chart) {
    chart.data = null;
    chart.data.labels = projectPerMonthLabels
    chart.update();
}


function projectPerMonthObject(json) {
    return {
        label: 'Projects',
        data: json,
        fill: false,
        borderColor: primaryColorChart,
        backgroundColor: primaryColorChart,
        tension: 0.1,
    };
}

function blogPerMonthObject(json) {
    return {
        label: 'Publihsed Blogs',
        data: json,
        fill: false,
        borderColor: secondColorChart,
        backgroundColor: secondColorChart,
        tension: 0.1,
    };
}

function projectPerMonthAjax(handleData, url) {
    $.ajax({
        url: url,
        success: function (data) {
            handleData(data);
        }
    });
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    if (i == 0) return bytes + ' ' + sizes[i];
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};




