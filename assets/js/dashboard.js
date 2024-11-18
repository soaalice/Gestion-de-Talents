// Déclarez une variable pour stocker l'instance d'ApexCharts
let benefChart = null;
let prevChart=null;
function benefDashChart(keys,values) {
  
  document.addEventListener("DOMContentLoaded", () => {
    const series = {
      "monthDataSeries1": {
        "prices":values,
        "dates": keys
      }
    };

    benefChart = new ApexCharts(document.querySelector("#benefChart"), {
      series: [{
        name: "Recette du mois",
        data: series.monthDataSeries1.prices
      }],
      chart: {
        id:'mychart',
        type: 'area',
        height: 350,
        zoom: {
          enabled: true // Activer le zoom
        }
      },
      dataLabels: {
        enabled: false // Activer les étiquettes de données
      },
      stroke: {
        curve: 'smooth' // Changer la courbe de la ligne à 'smooth'
      },
      colors: ['#E63D36'], // Changer la couleur de la ligne
      subtitle: {
        text: 'Mouvements de Prix', // Titre en français
        align: 'left'
      },
      labels: series.monthDataSeries1.dates,
      xaxis: {
        type: 'datetime',
        labels: {
          format: 'dd MMM' // Format des dates
        }
      },
      yaxis: {
        opposite: true
      },
      legend: {
        horizontalAlign: 'left'
      }
    });

    benefChart.render(); // Rendre le graphique
  });
}

function benefDash(url){
   ///create the xhr
   var xhr = createXHR();
   xhr.onreadystatechange = function () {
       if (xhr.readyState === XMLHttpRequest.DONE) {
           if (xhr.status === 200) {
               var recettes = JSON.parse(xhr.responseText, true)
               var values = []
               for (var key in recettes) {
                   values.push(recettes[key])
               }
               benefDashChart(Object.keys(recettes),values)
           } else {
               console.log(xhr.responseText)
           }
       }
   };
   var data=new FormData()
   data.append('annee','2023')
   sendXHR(xhr, "POST", url, false, data)
}

function prevDashChart(keys,values) {
  
  document.addEventListener("DOMContentLoaded", () => {
    const series = {
      "monthDataSeries1": {
        "prices":values,
        "dates": keys
      }
    };

    benefChart = new ApexCharts(document.querySelector("#prevChart"), {
      series: [{
        name: "Recette du mois",
        data: series.monthDataSeries1.prices
      }],
      chart: {
        id:'mychart',
        type: 'area',
        height: 350,
        zoom: {
          enabled: true // Activer le zoom
        }
      },
      dataLabels: {
        enabled: false // Activer les étiquettes de données
      },
      stroke: {
        curve: 'smooth' // Changer la courbe de la ligne à 'smooth'
      },
      colors: ['#E63D36'], // Changer la couleur de la ligne
      subtitle: {
        text: 'Mouvements de Prix', // Titre en français
        align: 'left'
      },
      labels: series.monthDataSeries1.dates,
      xaxis: {
        type: 'datetime',
        labels: {
          format: 'dd MMM' // Format des dates
        }
      },
      yaxis: {
        opposite: true
      },
      legend: {
        horizontalAlign: 'left'
      }
    });

    benefChart.render(); // Rendre le graphique
  });
}

function prevDash(url){
   ///create the xhr
   var xhr = createXHR();
   xhr.onreadystatechange = function () {
       if (xhr.readyState === XMLHttpRequest.DONE) {
           if (xhr.status === 200) {
               var recettes = JSON.parse(xhr.responseText, true)
               var values = []
               for (var key in recettes) {
                   values.push(recettes[key])
               }
               prevDashChart(Object.keys(recettes),values)
           } else {
               console.log(xhr.responseText)
           }
       }
   };
   var data=new FormData()
   data.append('annee','2022')
   sendXHR(xhr, "POST", url, false, data)
}

function camembertClasse(){
  document.addEventListener("DOMContentLoaded", () => {
    echarts.init(document.querySelector("#pieChart")).setOption({
      tooltip: {
        trigger: 'item'
      },
      legend: {
        orient: 'vertical',
        left: 'left'
      },
      series: [{
        name: 'Access From',
        type: 'pie',
        radius: '90%',
        data: [{
            value: 1048,
            name: 'Moyen de gamme'
          },
          {
            value: 735,
            name: 'Intermédiaire'
          },
          {
            value: 580,
            name: 'VIP'
          },
        ],
        emphasis: {
          itemStyle: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        }
      }]
    });
  });
}



