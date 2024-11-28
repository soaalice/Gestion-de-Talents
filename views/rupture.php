<?php 
  include "header.php";
?>
</head>
    
    <div class=" row mt-6">
        <div class="body pe-0 pe-md-0 pe-lg-0">
            <div class="row mx-0 pb-3 pe-md-3 pe-lg-3 ">
                
                <div class="col-lg-4 offset-4 col-md-12 col-sm-12 mb-5 mb-md-0 mb-lg-0 list py-3 px-4 ">
              
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
                                    <input type="text" name="daty" class="form-control border-11 rounded-33 ps-3 daty" id="date-input-debut" aria-describedby="" placeholder="" required>
                                    <label for="date-input" class="form-label ps-4 ">Date</label>
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
