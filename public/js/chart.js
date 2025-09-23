
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'doughnut',
      data: {
		 labels: chartLabels,
        datasets: [{
		  data: chartData,
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(25, 99, 13)',
            'rgb(54, 16, 235)',
            'rgb(55, 255, 255)',
            'rgb(255, 205, 86)',
            'rgb(153, 102, 255)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
            'rgb(0, 0, 0)',
            'rgb(100, 255, 100)',
            'rgb(200, 200, 200)'
          ],
          hoverOffset: 5,
          datalabels: {
			        anchor: 'center',
                    align: (context, value) => {
                        return context.dataIndex % 2 === 0 ? 'start' : 'end';
                    },
			
            backgroundColor: 'white',
            borderWidth: 5,
            borderRadius: 50,
            font: function (context) {
              var width = context.chart.width;
              var size = Math.round(width / 32);
              size = size > 14 ? 14 : size; 
              size = size < 9 ? 9 : size; 

              return {
                weight: 'bold',
                size: size
              };
            },

			 formatter: (value, context) => {
                        let total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                        let percentage = ((value / total) * 100).toFixed(2);
                        return percentage + '%';
                    },

          }
        }]
      },
      options: {

        plugins: {
          legend: {
            position: "right",
            labels: {
              font: function (context) {
                var width = context.chart.width;
                var size = Math.round(width / 32);
                size = size > 12 ? 12 : size;
                size = size < 6 ? 6 : size;
                return {
                  weight: 'bold',
                  size: size
                };
              },
            }
          },
          title: {
            display: true,
            text: "Struktura Twoich wydatków:",
            font: {
              size: 18,
              family: 'Arial'
            }

          },

          tooltip: {
            callbacks: {
			 
			       label: (context) => {
                            let total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                            if (total === 0) {
                                return context.label + ": " + context.raw + " (0%)";
                            }
							let percentage = ((context.raw / total) * 100).toFixed(2);
                            return context.label + ": " + context.raw + " PLN (" + percentage + "%)";
                        }
            }
          },

        },

      },
      plugins: [ChartDataLabels]
    });
