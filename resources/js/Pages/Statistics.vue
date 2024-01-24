<template>
    <div class="chart-container">
      <!-- Chart components for displaying bar graphs -->
      <Bar
        id="chart1"
        :options="chartOptions"
        :data="chartData"
      />
      <Bar
        id="chart2"
        :options="chartOptions"
        :data="chartData2"
      />
      <Pie
        id="chart3"
        :options="chartOptionsPie"
        :data="chartData3"
      />
    </div>
  </template>

  <style>
  .chart-container {
    display: flex;
    flex-wrap: wrap; /* Allows items within the container to wrap when necessary */
    justify-content: space-around; /* Distributes items evenly with space around them */
  }

  .chart-container > div {
    flex: 1; /* Makes each chart take up the available space */
    min-width: 300px; /* Sets a minimum width for the charts, causing them to wrap if the container is too small */
  }

  @media (max-width: 400px) {
    .chart-container {
      flex-direction: column; /* Changes the layout to vertical when screen width is less than 600px */
    }
  }
  </style>

  <script>
  import { Bar, Pie } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, } from 'chart.js'
  import { ref } from 'vue'

  // Registering the components necessary for Chart.js to function properly
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,)

  export default {
    name: 'BarCharts',
    components: { Bar, Pie },
    props: ['enquiriesWithHour','enquiriesWithday','enquiriesWithQuestion'], // Accepts the prop for the data to be visualized
    setup(props) {
      // Ref to reactive chart data
      const chartData = ref({
        labels: [],
        datasets: [
          {
            label: 'Enquiries per Hour',
            backgroundColor: '#f87979', // Color of the bars
            data: []
          }
        ]
      })
      const chartData2 = ref({
        labels: [],
        datasets: [
          {
            label: 'Enquiries per day',
            backgroundColor: '#f87979', // Color of the bars
            data: []
          }
        ]
      })
      const chartData3 = ref({
        labels: [],
        datasets: [
          {
            label: 'Enquiries per day',
            backgroundColor: '#f87979', // Color of the bars
            data: []
          }
        ]
      })

      // Chart configuration options
      const chartOptions = {
        responsive: true, // Makes the chart responsive to window resizing
        plugins: {
          legend: {
            display: false // Hides the legend
          }
        }
      }
      const chartOptionsPie = {

        responsive: true, // Makes the chart responsive to window resizing
        plugins: {
          legend: {
        
            display:false,
          },
        
        }
      }

      // Function to process the enquiries and populate the chart data
      const processEnquiries = () => {
        const counts = new Array(24).fill(0); // Initialize counts for 24 hours
        props.enquiriesWithHour.forEach(enquiry => {
          const hour = parseInt(enquiry.hour, 10); // Parse the hour as an integer
          counts[hour]++; // Increment the count for the hour
        });
        chartData.value.labels = [...Array(24).keys()].map(hour => `${hour}:00`); // Create labels for each hour
        chartData.value.datasets[0].data = counts; // Assign the counts to the chart data
      } 
      const processEnquiries2 = () => {
        const counts = new Array(31).fill(0); // Initialize counts for 24 hours
        props.enquiriesWithHour.forEach(enquiry => {
          const day = parseInt(enquiry.day, 10); // Parse the hour as an integer
          counts[day]++; // Increment the count for the hour
        });
        chartData2.value.labels = [...Array(32).keys()].map(day => `${day}`); // Create labels for each hour
        chartData2.value.datasets[0].data = counts; // Assign the counts to the chart data
      }
      
      const processEnquiries3 = () => {
  const counts = [0, 0]; // 初始化有两个元素的数组，用于计数
  props.enquiriesWithQuestion.forEach(enquiry => {
    const has_question = enquiry.has_question; // 解析问题是否存在为一个整数
    counts[has_question]++; // 根据问题的有无增加计数
  });
  chartData3.value.labels = ['No', 'Yes']; // 创建标签
  chartData3.value.datasets[0].data = counts; // 将计数赋值给饼图数据
}

      // Process the data initially
      processEnquiries();
      processEnquiries2();
      processEnquiries3();

      // Expose chartData and chartOptions to the template
      return { chartData,chartData2,chartData3, chartOptions,chartOptionsPie }
    }
  }
  </script>
