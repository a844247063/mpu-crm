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

  @media (max-width: 600px) {
    .chart-container {
      flex-direction: column; /* Changes the layout to vertical when screen width is less than 600px */
    }
  }
  </style>

  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  import { ref } from 'vue'

  // Registering the components necessary for Chart.js to function properly
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  export default {
    name: 'BarCharts',
    components: { Bar },
    props: ['enquiriesWithHour','enquiriesWithday'], // Accepts the prop for the data to be visualized
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

      // Chart configuration options
      const chartOptions = {
        responsive: true, // Makes the chart responsive to window resizing
        plugins: {
          legend: {
            display: false // Hides the legend
          }
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

      // Process the data initially
      processEnquiries();
      processEnquiries2();

      // Expose chartData and chartOptions to the template
      return { chartData,chartData2, chartOptions }
    }
  }
  </script>
