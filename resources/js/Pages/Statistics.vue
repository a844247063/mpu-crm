<template>
  <Bar
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
  />
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import { ref } from 'vue'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Bar },
  props: ['enquiriesWithHour','fields'],
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
      // 创建一个数组来存储每小时的计数
      const counts = new Array(24).fill(0);
      props.enquiriesWithHour.forEach(enquiry => {
        // 使用服务器发送的小时数
        const hour = parseInt(enquiry.hour);
        counts[hour]++; // 增加对应小时的计数
      });
      // 更新chartData
      chartData.value.labels = [...Array(24).keys()].map(hour => `${hour}:00`);
      chartData.value.datasets[0].data = counts;
    }

    processEnquiries();

    return { chartData, chartOptions }
  }
}
</script>