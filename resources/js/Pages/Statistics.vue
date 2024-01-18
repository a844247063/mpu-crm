<template>
    <div class="chart-container">
      <Bar
        id="chart1"
        :options="chartOptions"
        :data="chartData"
      />
      <Bar
        id="chart2"
        :options="chartOptions"
        :data="chartData"
      />
    </div>
  </template>

  <style>
  .chart-container {
    display: flex;
    flex-wrap: wrap; /* 允许容器内的项目在必要时换行 */
    justify-content: space-around;
  }

  .chart-container > div {
    flex: 1; /* 使得每个图表占据可用空间 */
    min-width: 300px; /* 设定图表的最小宽度，当容器太小无法容纳两个图表时会换行 */
  }

  @media (max-width: 600px) {
    .chart-container {
      flex-direction: column; /* 当屏幕宽度小于600px时，改变排列方向为垂直 */
    }
  }
  </style>


  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  import { ref } from 'vue'

  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  export default {
    name: 'BarCharts',
    components: { Bar },
    props: ['enquiriesWithHour', 'fields'],
    setup(props) {
      const chartData = ref({
        labels: [],
        datasets: [
          {
            label: 'Enquiries per Hour',
            backgroundColor: '#f87979',
            data: []
          }
        ]
      })

      const chartOptions = {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }

      const processEnquiries = () => {
        const counts = new Array(24).fill(0);
        props.enquiriesWithHour.forEach(enquiry => {
          const hour = parseInt(enquiry.hour);
          counts[hour]++;
        });
        chartData.value.labels = [...Array(24).keys()].map(hour => `${hour}:00`);
        chartData.value.datasets[0].data = counts;
      }

      processEnquiries();

      return { chartData, chartOptions }
    }
  }
  </script>
