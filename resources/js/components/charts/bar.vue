<template>
    <div>
      <div id="chart">
        <div id="chart-timeline">
          <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import moment from 'moment';
  
  export default {
    data() {
        return {
        chartOptions: {
            chart: {
            height: 350,
            type: 'bar',
            zoom: {
                enabled: false
            }
            },
            dataLabels: {
            enabled: false
            },
            stroke: {
            curve: 'smooth' // This line can be removed
            },
            title: {
                text: '',
                align: 'left',
                show: true,
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
        }
        };
    },
    props: {
      yAxisLabel: { type: [String], required: false },
      xAxisLabel: { type: [String], required: false },
      series: { type: [Array], required: true },
    },
    watch: {
      series: {
        immediate: true,
        handler(newSeries) {
          this.$nextTick(() => {
  
          });
        },
      },
      yAxisLabel(newYAxisLabel) {
        this.chartOptions.annotations.yaxis.label.text = newYAxisLabel;
      },
      xAxisLabel(newXAxisLabel) {
        this.chartOptions.annotations.xaxis.label.text = newXAxisLabel;
      },
    },
  };
  </script>
  