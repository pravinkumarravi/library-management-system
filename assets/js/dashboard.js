document.addEventListener('DOMContentLoaded', function () {
    const chartOne = document.querySelector('#chartOne');

    if (chartOne && window.ApexCharts) {
        const labels = JSON.parse(chartOne.dataset.labels);
        const data = JSON.parse(chartOne.dataset.data);

        const options = {
            series: [
                {
                    name: 'Issues',
                    data: data,
                },
            ],
            colors: ['#465fff'],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                type: 'bar',
                height: 180,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '39%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end',
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 4,
                colors: ['transparent'],
            },
            xaxis: {
                categories: labels,
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'left',
                fontFamily: 'Outfit',
                markers: {
                    radius: 99,
                },
            },
            yaxis: {
                title: false,
            },
            grid: {
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                x: {
                    show: false,
                },
                y: {
                    formatter: function (val) {
                        return val + ' books';
                    },
                },
            },
        };

        new ApexCharts(chartOne, options).render();
    }

    const chartTwo = document.querySelector('#chartTwo');

    if (chartTwo && window.ApexCharts) {
        const value = Number(chartTwo.dataset.value);

        const options = {
            series: [value],
            colors: ['#465FFF'],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                type: 'radialBar',
                height: 195,
                sparkline: {
                    enabled: true,
                },
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    hollow: {
                        size: '80%',
                    },
                    track: {
                        background: '#E4E7EC',
                        strokeWidth: '100%',
                        margin: 5,
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            fontSize: '36px',
                            fontWeight: '600',
                            offsetY: 45,
                            color: '#1D2939',
                            formatter: function (val) {
                                return val + '%';
                            },
                        },
                    },
                },
            },
            fill: {
                type: 'solid',
                colors: ['#465FFF'],
            },
            stroke: {
                lineCap: 'round',
            },
            labels: ['Availability'],
        };

        new ApexCharts(chartTwo, options).render();
    }
});
