<template>
    <div>
      <canvas id="myChart"></canvas>
    </div>
  </template>
  
  <script>
  import Chart from 'chart.js/auto';
  import axios from 'axios';
  
  export default {
    name: 'EnquiriesChart',
    data() {
      return {
        chart: null
      };
    },
    mounted() {
      this.fetchEnquiryCount();
    },
    methods: {
      fetchEnquiryCount() {
        axios.get('/api/enquiries/count') // Adjust the URL as needed for your API endpoint
          .then((response) => {
            const count = response.data;
            const chartData = {
              labels: ['Enquiries'],
              datasets: [{
                label: 'Number of Enquiries',
                data: [count],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            };
            this.createChart(chartData);
          })
          .catch((error) => {
            console.error('Error fetching enquiry count:', error);
          });
      },
      createChart(chartData) {
        const ctx = document.getElementById('myChart').getContext('2d');
        this.chart = new Chart(ctx, {
          type: 'bar',
          data: chartData,
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    }
  }
  </script>