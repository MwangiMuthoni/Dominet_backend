<template>
  <div>
    <div id="chart">
      <div id="chart-timeline">
        <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
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
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: '1'
        },
        title: {
          text: '',
          align: 'left',
          show: true,
          curve: 'smooth',
          lineCap: 'round',
          width: 1,
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
          },
        },
        colors: ['#FF4275', '#0f4c3d'], 
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
      }
    };
  },
  props: {
    colors: { type: [Array], required: true },
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
