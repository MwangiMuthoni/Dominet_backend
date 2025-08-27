<template>
    <div style="display: flex; flex-direction: column;">
      <label>Filter by date</label>
      <date-range-picker
                        ref="picker"
                        :opens="opens"
                        :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy HH:mm:ss' }"
                        :minDate="minDate" :maxDate="maxDate"
                        :singleDatePicker="singleDatePicker"
                        :timePicker="timePicker"
                        :timePicker24Hour="timePicker24Hour"
                        :showWeekNumbers="showWeekNumbers"
                        :showDropdowns="showDropdowns"
                        :autoApply="autoApply"
                        v-model="dateRange"
                        @update="setDate()"
                        :linkedCalendars="linkedCalendars"
                        :value-type="valueType"
                >
                    <template v-slot:input="picker" style="min-width: 350px;">
                        {{ picker.startDate | date }} - {{ picker.endDate | date }}
                    </template>
                </date-range-picker>
    </div>
</template>


  <script>

    import DateRangePicker from 'vue2-daterange-picker';
    import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
    import moment from 'moment';
    export default {

    components:{DateRangePicker},
    created(){
        },
    updated(){
        },
      data:() => ({
        dateRange:{
              startDate: moment().startOf('month'),
              endDate: moment().endOf('month'),
        },
        valueType:{
          value2date: (value) => {
            const date = new Date(value)
            return value ? moment(value, 'LL').toDate() : null
          },
          date2value: (date) => {
            return date ? moment(date).format('LL') : null
          }
        },
        opens:"center",
        minDate:"2023-01-01",
        maxDate:moment().endOf('year').format('YYYY-MM-DD HH:mm:ss'),
        singleDatePicker:false,
        timePicker:true,
        timePicker24Hour:true,
        showWeekNumbers:true,
        showDropdowns:true,
        autoApply:false,
        linkedCalendars:true,
      }),
      filters: {
        dateCell (value) {
          let dt = new Date(value)    
          return dt.getDate()
        },
        date (val) {
          return val ? val.toLocaleString() : ''
        }
      },

      methods: {
        setDate: async function () {
            var startDate=moment(this.dateRange.startDate).format('YYYY-MM-DD HH:mm:ss');
            var endDate=moment(this.dateRange.endDate).format('YYYY-MM-DD HH:mm:ss');
            this.$emit('daterange',{'startDate':startDate,'endDate':endDate});
          },
      },
    }
  </script>