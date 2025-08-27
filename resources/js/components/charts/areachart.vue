<template>
    <div>
      <div id="chart">
                <div class="toolbar">
                  <button id="one_day"
                      @click="updateData('one_day')" class="btn btn-sm" :class="{active: selection==='one_day'}"
                      >
                    1D
                  </button>
                  <button id="one_week"
                      @click="updateData('one_week')" class="btn btn-sm" :class="{active: selection==='one_week'}"
                      >
                    1W
                  </button>
                  <button id="one_month"
                      @click="updateData('one_month')" class="btn btn-sm" :class="{active: selection==='one_month'}"
                      >
                    1M
                  </button>

                  <button id="six_months"
                      @click="updateData('six_months')" class="btn btn-sm" :class="{active: selection==='six_months'}"
                      >
                    6M
                  </button>

                  <button id="one_year"

                      @click="updateData('one_year')" class="btn btn-sm" :class="{active: selection==='one_year'}"
                      >
                    1Y
                  </button>

                  <button id="ytd"
                      @click="updateData('ytd')" class="btn btn-sm" :class="{active: selection==='ytd'}"
                      >
                    YTD
                  </button>

                  <button id="all"
                      @click="updateData('all')" class="btn btn-sm" :class="{active: selection==='all'}"
                      >
                    ALL
                  </button>
                </div>
                <div id="chart-timeline">
                <apexchart type="area" height="350" ref="chart" :options="chartOptions" :series="series"></apexchart>
              </div>
            </div>
    </div>
</template>
<script>

    import moment from 'moment';

    export default {
    created(){
        // this.chartOptions.annotations.yaxis.label.text=this.yAxisLabel;
        // this.chartOptions.annotations.xaxis.label.text=this.xAxisLabel;
        this.chartOptions.colors=this.colors;
        this.chartOptions.fill.colors=this.colors;
        },

    updated(){
        },
    data:() => ({
        errors:[],
        selection: 'all',
        chartOptions: {
            chart: {
              id: 'area-datetime',
              type: 'area',
              height: 350,
              zoom: {
                autoScaleYaxis: true
              }
            },
            annotations: {
              yaxis: [{
                y: 30,
                borderColor: '#999',
                label: {
                  show: true,
                  text: '',
                  style: {
                    color: "#fff",
                    background: '#FF4275'
                  }
                }
              }],
              xaxis: [{
                x: new Date('29 Jul 2022').getTime(),
                borderColor: '#999',
                yAxisIndex: 0,
                label: {
                  show: true,
                  text: 'test',
                  style: {
                    color: "#fff",
                    background: '#775DD0'
                  }
                }
              }]
            },
            dataLabels: {
              enabled: true,
            },
            markers: {
              size: 0,
              style: 'hollow',
            },
            xaxis: {
              type: 'datetime',
              min: new Date().getTime(),
              tickAmount: 6,
            },
            tooltip: {
              x: {
                format: 'dd MMM yyyy'
              }
            },
            colors:[],
            fill: {
              colors:[],
              type: 'gradient',
              gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
              }
            },
            stroke: {
                show: true,
                curve: 'smooth',
                lineCap: 'round',
                width: 1,
            }
          },
      }),
      methods: {
        updateData: function(timeline) {
            this.selection = timeline
            switch (timeline) {
              case 'one_day':
                this.$refs.chart.zoomX(
                  moment().startOf('day').valueOf(),
                  moment().endOf('day').valueOf()
                )
                break
              case 'one_week':
                this.$refs.chart.zoomX(
                  moment().startOf('week').valueOf(),
                  moment().endOf('week').valueOf()
                )
                break
              case 'one_month':
                this.$refs.chart.zoomX(
                  moment().startOf('month').valueOf(),
                  moment().endOf('month').valueOf()
                )
                break
              case 'six_months':
                this.$refs.chart.zoomX(
                  moment().subtract(6, 'months').valueOf(),
                  moment().valueOf()
                )
                break
              case 'one_year':
                this.$refs.chart.zoomX(
                  moment().subtract(12, 'months').valueOf(),
                  moment().valueOf()
                )
                break
              case 'ytd':
                this.$refs.chart.zoomX(
                  moment().startOf('year').valueOf(),
                  moment().valueOf()
                )
                break
              case 'all':
                  if (this.series && this.series.length > 0 && this.series[0].data) {
                  var series=this.series[0].data;
                  const maxDate =moment(series[0][0]);
                  const minDate =moment(series[series.length - 1][0]);
                  this.$refs.chart.zoomX(minDate.valueOf(), maxDate.valueOf());
                  this.chartOptions.xaxis.min = minDate.valueOf();
                  this.chartOptions.xaxis.max = maxDate.valueOf();}


                  // let minValue = Infinity;
                  // let maxValue = -Infinity;
                  // this.series.forEach(item => {
                  //   if (item.value < minValue) {minValue = item.value;}
                  //   if (item.value > maxValue) {maxValue = item.value;}
                  // });
                  // const buffer = (maxValue - minValue) * 0.1;
                  // this.chartOptions.yaxis.min = minValue - buffer;
                  // this.chartOptions.yaxis.max = maxValue + buffer;

                break
              default:
            }
          },
      },
      props: {
          colors: {type: [Array], required: true},
          yAxisLabel: {type: [String], required: false},
          xAxisLabel: {type: [String], required: false},
          series: {type: [Array], required: true},
          },
      watch: {
          series: {
            immediate: true,
            handler(newSeries) {
              this.$nextTick(() => {this.updateData('all');});
            },
          },
          yAxisLabel(newYAxisLabel) {
              this.chartOptions.annotations.yaxis.label.text = newYAxisLabel;
            },
          xAxisLabel(newXAxisLabel) {
              this.chartOptions.annotations.xaxis.label.text = newXAxisLabel;
            },
        },
    }
  </script>
