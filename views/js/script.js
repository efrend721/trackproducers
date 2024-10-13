class ChartManager {
  constructor(chartsSelector, dataTableSelector) {
      this.chartsSelector = chartsSelector;
      this.dataTableSelector = dataTableSelector;
      this.initCharts();
      this.initDataTables();
  }

  initCharts() {
      document.querySelectorAll(this.chartsSelector).forEach((chart) => {
          const areaNames = JSON.parse(chart.dataset.areaNames);
          const areaNum = JSON.parse(chart.dataset.areaNum);
          const numJobsDone = chart.dataset.numJobsDone; // Assuming each canvas has a data-num-jobs-done attribute
          const canvasId = chart.id;
          //console.log(areaNames);
          // Try to get the existing Chart.js chart instance directly from the canvas.
          // Note: Chart.js stores the chart instance in the canvas itself starting from version 3.
          const existingChart = Chart.getChart(canvasId); 
          if (existingChart) {
              existingChart.destroy(); // Destruye el gráfico existente si existe
          }

          var ctx = chart.getContext("2d");
          var myChart = new Chart(ctx, {
              type: "bar",
              data: {
                  //labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                  labels: areaNames,
                  datasets: [{
                      label: `# of Jobs Done: ${numJobsDone}`,
                      //data: [12, 19, 3, 5, 2, 3],
                      data: areaNum,
                      backgroundColor: [
                          "rgba(255, 99, 132, 0.2)",
                          "rgba(54, 162, 235, 0.2)",
                          "rgba(255, 206, 86, 0.2)",
                          "rgba(75, 192, 192, 0.2)",
                          "rgba(153, 102, 255, 0.2)",
                          "rgba(255, 159, 64, 0.2)",
                      ],
                      borderColor: [
                          "rgba(255, 99, 132, 1)",
                          "rgba(54, 162, 235, 1)",
                          "rgba(255, 206, 86, 1)",
                          "rgba(75, 192, 192, 1)",
                          "rgba(153, 102, 255, 1)",
                          "rgba(255, 159, 64, 1)",
                      ],
                      borderWidth: 1,
                  }],
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true,
                      },
                  },
              },
          });
      });
  }

  initDataTables() {
      $(document).ready(() => {
          $(this.dataTableSelector).DataTable();
      });
  }
}

document.addEventListener('DOMContentLoaded', function() {
  new ChartManager('.chart', '.data-table');
});
