<template>
    <div style="width: 100%;">
      <div id="chart">
        <div id="chart-timeline" style="height: 100%;">
          <apexchart type="pie" :height="chartHeight" :options="chartOptions" :series="series"></apexchart>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import moment from 'moment';
  
  export default {
    data() {
      return {
        chartHeight: 500,
        chartOptions: {
          chart: {
            height: '100%',
            type: 'pie',
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: false
          },
          grid: {
            row: {
              colors: ['#f3f3f3', 'transparent'],
              opacity: 0.5
            }
          },
          labels: [],
          colors: ['#FF4275', '#0f4c3d', '#9065b0', '#3D9970', '#FFD700', '#F6511D', '#6d1612', '#FF8C69', '#C9A6FF'],
        }
      };
    },
    created() {
      this.chartOptions.labels = this.lab;
    },
    props: {
      yAxisLabel: { type: [String], required: false },
      xAxisLabel: { type: [String], required: false },
      series: { type: [Array], required: true },
      options: { type: [Object], required: true },
      lab: { type: [Array], required: true },
      name: { type: [String], required: false },
    },
    watch: {
      series: {
        immediate: true,
        handler(newSeries) {
          this.$nextTick(() => {
            // Handle series change if needed
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
  