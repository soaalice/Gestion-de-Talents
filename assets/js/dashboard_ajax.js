
function updateBenefDash(keys, values) {
    const series = {
      "monthDataSeries1": {
        "prices": values,
        "dates": keys
      }
    };
  
    if (benefChart) {
      benefChart.updateSeries([{
        data: series.monthDataSeries1.prices,
      },
    ]);
  
      benefChart.updateOptions({
        labels: series.monthDataSeries1.dates
      });
    }
  }
  
  function getRecetteAnnee(form, url) {
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
                updateBenefDash(Object.keys(recettes),values)
            } else {
                alert(xhr.responseText);
                console.log(xhr.responseText)
            }
        }
    };
    sendXHR(xhr, "POST", url, true, form)
  }

  function getPopularParking(form, url) {
    ///create the xhr
    var xhr = createXHR();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var parkings = JSON.parse(xhr.responseText, true)
                let rows = '';
                parkings.forEach(parking => {
                  rows += `
                  <tr>
                      <td>${parking.lieu_nom}</td>
                      <td>${parking.classe_nom}</td>
                      <td>${parking.description}</td>
                      <td>${parking.nombre_entrees}</td>
                  </tr>
              `
              });
              document.getElementById("bodyPopular").innerHTML=rows
            } else {
                alert(xhr.responseText);
                console.log(xhr.responseText)
            }
        }
    };
    sendXHR(xhr, "POST", url, true, form)
    document.getElementById("bodyPopular").innerHTML="Chargement ...."
  }
  