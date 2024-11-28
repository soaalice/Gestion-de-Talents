<?php 
  include "header.php";
?>
<script src="assets/js/index.global.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
      
          var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: '2023-01-12',
            navLinks: true,
            businessHours: true,
            editable: true,
            selectable: true,
            events: [
              {
                title: 'Business Lunch',
                start: '2023-01-03T13:00:00',
                constraint: 'businessHours'
              },
              {
                title: 'Meeting',
                start: '2023-01-13T11:00:00',
                constraint: 'availableForMeeting',
                color: '#257e4a'
              },
              {
                title: 'Conference',
                start: '2023-01-18',
                end: '2023-01-20'
              },
              {
                title: 'Party',
                start: '2023-01-29T20:00:00'
              },
      
              {
                groupId: 'availableForMeeting',
                start: '2023-01-11T10:00:00',
                end: '2023-01-11T16:00:00',
                display: 'background'
              },
              {
                groupId: 'availableForMeeting',
                start: '2023-01-13T10:00:00',
                end: '2023-01-13T16:00:00',
                display: 'background'
              },
      
              {
                start: '2023-01-24',
                end: '2023-01-28',
                overlap: false,
                display: 'background',
                color: '#ff9f89'
              },
              {
                start: '2023-01-06',
                end: '2023-01-08',
                overlap: false,
                display: 'background',
                color: '#ff9f89'
              }
            ]
          });
      
          calendar.render();
        });    
      </script>
      <style>
         #calendar a {
          /* color: #107c41; */
          /* color: black; */
         }
      </style>
</head>
    
    <div class=" row mt-6">
        <div class="body pe-0 pe-md-0 pe-lg-0">
            <div class="row mx-0 pb-3 pe-md-3 pe-lg-3 ">
                <div class="col-lg-8 col-md-12 mx-0 mt-1 ps-5 ">
                    <div class="row p-3 mt-5 bg-light border-11">
                        <div id='calendar'></div>
                    </div>
                   
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 mb-5 mb-md-0 mb-lg-0 list py-3 px-4 ">
              
                    <div class="row text-center bg-white-c border-11 p-2 mb-2">
                        <div class="col-12 ">
                            <div class="contenue row justify-content-start h-100">
                                <div class="col-12 color-1 border-11 p-2 my-3 scale-2 fw-bolder"><h4>Planification de conge</h4></div>
                            </div>
                        </div>
    
                        <div class="col-12  p-1 colon-2 justify-content-center">
                            <form action="" method="post">
                                <div class="form-floating mb-3">
                                    <textarea name="description" class="form-control border-11 rounded-33 ps-3 desc" style="height: 11rem;" id="" aria-describedby="" placeholder="" required></textarea>
                                    <label for="date-input" class="form-label ps-4 ">Description</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="date_debut" class="form-control border-11 rounded-33 ps-3 daty" id="date-input-debut" aria-describedby="" placeholder="" required>
                                    <label for="date-input" class="form-label ps-4 ">Date debut</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="date_fin" class="form-control border-11 rounded-33 ps-3 daty" id="date-input-fin" aria-describedby="" placeholder="" required>
                                    <label for="date-input" class="form-label ps-4 ">Date fin</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="" class="form-control border-11 rounded-33 ps-3" id="exampleInputPassword1">
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                        <option value="">4</option>
                                    </select>
                                    <label for="exampleInputPassword1" class="form-label ps-4">Type de Conge</label>
                                </div>
                                <div class="row justify-content-center mb-3 mb-md-5 mb-lg-0">
                                    <div class="col-md-12">
                                        <input type="submit" class="form-control border-11  color-white rounded-33 btn btn-success" style="" value="submit">
                                    </div>
                                </div>
                            
                            </form>
                        </div>
    
                      
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/conf.js"></script>
